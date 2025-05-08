<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AkunMahasiswa;
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
        return view('mahasiswa.semester4.pelaporan.pelaporan-pbl');
    }

    public function form_laporan() {
        return view('mahasiswa.semester4.pelaporan.form-laporan');
    }
}
