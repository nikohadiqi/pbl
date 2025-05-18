<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Anggota_Tim_Pbl;
use App\Models\TimPbl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ValidasiController extends Controller
{
    public function index()
    {
        $nip = Auth::guard('dosen')->user()->nim;

        $timPBL = TimPbl::with(['anggota.mahasiswaFK', 'manproFK', 'periodeFK'])
            ->where('manpro', $nip)
            ->get();

        return view('dosen.validasi.validasi-tim', compact('timPBL'));
    }

    // Validasi Tim
    public function approve($kode_tim)
    {
        $nip = Auth::guard('dosen')->user()->nim;

        $tim = TimPbl::where('kode_tim', $kode_tim)
            ->where('manpro', $nip) // pastikan dosen adalah manpro
            ->first();

        if (!$tim) {
            Alert::error('Gagal!', 'Anda tidak berhak memvalidasi tim ini.');
            return redirect()->route('dosen.validasi-tim');
        }

        $tim->update(['status' => 'approved']);

        Alert::success('Berhasil!', 'Tim PBL Mahasiswa telah divalidasi!');
        return redirect()->route('dosen.validasi-tim');
    }

    // Reject Tim
    public function reject(Request $request, $kode_tim)
    {
        $nip = Auth::guard('dosen')->user()->nim;

        $request->validate([
            'alasan_reject' => 'required|string|max:1000',
        ]);

        $tim = TimPbl::where('kode_tim', $kode_tim)
            ->where('manpro', $nip)
            ->first();

        if (!$tim) {
            Alert::error('Gagal!', 'Anda tidak berhak menolak tim ini.');
            return redirect()->route('dosen.validasi-tim');
        }

        $tim->update([
            'status' => 'rejected',
            'alasan_reject' => $request->alasan_reject,
        ]);

        Anggota_Tim_Pbl::where('kode_tim', $kode_tim)->delete();

        Alert::success('Berhasil!', 'Tim PBL telah ditolak.');
        return redirect()->route('dosen.validasi-tim');
    }
}
