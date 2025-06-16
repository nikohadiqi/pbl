<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use App\Models\AkunMahasiswa;
use App\Models\Mahasiswa;
use App\Models\AnggotaTimPbl;
use App\Models\PeriodePBL;
use App\Models\TimPBL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    public function kelolaTim($kode_tim)
    {
        $tim = TimPBL::with(['anggota.mahasiswaFK'])->where('kode_tim', $kode_tim)->firstOrFail();
        return view('dosen.validasi.kelola-tim', compact('tim'));
    }

    public function tambahAnggota(Request $request, $kode_tim)
    {
        $request->validate([
            'nim' => [
            'required',
            'unique:akun_mahasiswa,nim',
            'exists:data_mahasiswa,nim'
        ],
            'password' => 'required|min:6',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM ini sudah digunakan oleh akun lain.',
            'nim.exists' => 'NIM ini tidak terdaftar sebagai mahasiswa.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Buat akun mahasiswa
        AkunMahasiswa::create([
            'nim' => $request->nim,
            'password' => Hash::make($request->password),
            'kode_tim' => $kode_tim,
            'role' => 'mahasiswa',
        ]);

        // Tambahkan ke anggota_tim_pbl
        AnggotaTimPbl::create([
            'kode_tim' => $kode_tim,
            'nim' => $request->nim,
        ]);

        Alert::success('Berhasil!', 'Anggota berhasil ditambahkan.');
        return redirect()->route('dosen.validasi-tim.kelola', $kode_tim);
    }
    public function hapusAnggota($kode_tim, $nim)
    {
        // Hapus dari akun_mahasiswa
        AkunMahasiswa::where('nim', $nim)->where('kode_tim', $kode_tim)->delete();

        // Hapus dari anggota_tim_pbl
        AnggotaTimPbl::where('nim', $nim)->where('kode_tim', $kode_tim)->delete();

        Alert::success('Berhasil!', 'Anggota berhasil dihapus.');
        return redirect()->route('dosen.validasi-tim.kelola', $kode_tim);
    }

    public function resetPassword(Request $request, $kode_tim, $nim)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        AkunMahasiswa::where('nim', $nim)->where('kode_tim', $kode_tim)
            ->update(['password' => Hash::make($request->password)]);

        Alert::success('Berhasil!', 'Password berhasil diubah.');
        return redirect()->route('dosen.validasi-tim.kelola', $kode_tim);
    }
}
