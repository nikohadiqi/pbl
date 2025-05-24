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
        $periodeAktif = PeriodePBL::where('status', 'Aktif')->first();
        $kode_tim = getKodeTimByAuth();

        $tim = null;
        $timMembers = collect();
        $logbookTerakhir = null;
        $laporanTerakhir = null;

        if ($kode_tim && $periodeAktif) {
            $tim = TimPbl::with(['anggota.mahasiswaFK', 'manproFK', 'rencanaProyek', 'logbooks'])
                ->where('kode_tim', $kode_tim)
                ->where('periode', $periodeAktif->id)
                ->first();

            if ($tim) {
                $timMembers = $tim->anggota;

                // Logbook terakhir
                $logbookTerakhir = $tim->logbooks->sortByDesc('minggu')->first();

                // Cek laporan terakhir
                $hasUAS = PelaporanUAS::where('kode_tim', $kode_tim)->exists();
                $hasUTS = PelaporanUTS::where('kode_tim', $kode_tim)->exists();

                if ($hasUAS) {
                    $laporanTerakhir = 'Laporan UAS';
                } elseif ($hasUTS) {
                    $laporanTerakhir = 'Laporan UTS';
                }
            }
        }

        return view('mahasiswa.dashboard-mahasiswa', [
            'kode_tim' => $kode_tim,
            'tim_members' => $timMembers,
            'tim' => $tim,
            'logbookTerakhir' => $logbookTerakhir,
            'laporanTerakhir' => $laporanTerakhir,
        ]);
    }
}
