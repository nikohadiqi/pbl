<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AkunMahasiswa;
use App\Models\PelaporanUTS;
use App\Models\PelaporanUAS;
use App\Models\Anggota_Tim_Pbl; // Tambahkan model Anggota_Tim_Pbl
use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    public function index() {
        // Ambil data mahasiswa yang sedang login
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Ambil semua anggota tim berdasarkan kode_tim dari tabel anggota_tim_pbl
        $timMembers = Anggota_Tim_Pbl::where('kode_tim', $mahasiswa->kode_tim)->get();

        // Kirim data ke view dashboard-mahasiswa
        return view('mahasiswa.dashboard-mahasiswa', [
            'kode_tim' => $mahasiswa->kode_tim,
            'tim_members' => $timMembers, // Tim anggota sesuai kode_tim
        ]);
    }
   public function laporan_pbl() {
     $nim = Auth::guard('mahasiswa')->user()->nim;
        $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Anda belum tergabung dalam tim PBL.');
        }

        $kode_tim = $anggota->kode_tim;

        // Ambil data laporan UTS dan UAS berdasarkan kode_tim jika ada
        $pelaporanUTS = PelaporanUTS::where('kode_tim', $kode_tim)->first();
        $pelaporanUAS = PelaporanUAS::where('kode_tim', $kode_tim)->first();
    return view('mahasiswa.semester4.pelaporan.pelaporan-pbl', compact('kode_tim', 'pelaporanUTS', 'pelaporanUAS'));
    
}

    // public function form_laporan() {
    //     return view('mahasiswa.semester4.pelaporan.form-laporan');
    // }

}
