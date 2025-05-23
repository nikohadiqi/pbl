<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AkunMahasiswa;
use App\Models\PelaporanUTS;
use App\Models\PelaporanUAS;
use App\Models\Anggota_Tim_Pbl; // Tambahkan model Anggota_Tim_Pbl
use App\Models\PeriodePBL;
use App\Models\TimPbl;
use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Ambil periode aktif
        $periodeAktif = PeriodePBL::where('status', 'Aktif')->first();

        // Pakai helper untuk ambil kode_tim
        $kode_tim = getKodeTimByAuth();

        $tim = null;
        $timMembers = collect();

        if ($kode_tim && $periodeAktif) {
            $tim = TimPbl::with(['anggota.mahasiswaFK', 'manproFK', 'rencanaProyek', 'logbooks'])
                ->where('kode_tim', $kode_tim)
                ->where('periode', $periodeAktif->id)
                ->first();

            if ($tim) {
                $timMembers = $tim->anggota;
            }
        }

        return view('mahasiswa.dashboard-mahasiswa', [
            'kode_tim' => $kode_tim,
            'tim_members' => $timMembers,
            'tim' => $tim,
        ]);
    }
}
