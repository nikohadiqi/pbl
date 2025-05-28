<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use App\Models\AnggotaTimPbl;
use App\Models\PeriodePBL;
use App\Models\TimPBL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ValidasiController extends Controller
{
    public function index()
    {
        $nip = Auth::guard('dosen')->user()->nim;

        $timPBL = TimPBL::with(['anggota.mahasiswaFK', 'manproFK', 'periodeFK'])
            ->where('manpro', $nip)
            ->whereHas('periodeFK', function ($query) {
                $query->where('status', 'Aktif');
            })
            ->get();

        return view('dosen.validasi.validasi-tim', compact('timPBL'));
    }

    // Validasi Tim
    public function approve($kode_tim)
    {
        $nip = Auth::guard('dosen')->user()->nim;

        $tim = TimPBL::where('kode_tim', $kode_tim)
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

        $tim = TimPBL::where('kode_tim', $kode_tim)
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

        AnggotaTimPbl::where('kode_tim', $kode_tim)->delete();

        Alert::success('Berhasil!', 'Tim PBL telah ditolak.');
        return redirect()->route('dosen.validasi-tim');
    }

    public function history(Request $request)
    {
        $nip = Auth::guard('dosen')->user()->nim;

        $periodes = PeriodePBL::where('status', 'Selesai')->orderByDesc('created_at')->get();

        $periodeId = $request->get('periode_id') ?? null;

        if ($periodeId) {
            $timPBL = TimPBL::with(['anggota.mahasiswaFK', 'manproFK', 'periodeFK'])
                ->where('manpro', $nip)
                ->where('periode', $periodeId)
                ->orderByDesc('created_at')
                ->get();
        } else {
            $timPBL = collect(); // kosongkan jika belum pilih periode
        }

        return view('dosen.validasi.history-tim-pbl', compact('timPBL', 'periodes', 'periodeId'));
    }

}
