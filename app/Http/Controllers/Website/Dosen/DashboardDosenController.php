<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use App\Models\AnggotaTimPbl;
use App\Models\Logbook;
use App\Models\NilaiMahasiswa;
use App\Models\PelaporanUAS;
use App\Models\PelaporanUTS;
use App\Models\Pengampu;
use App\Models\PeriodePBL;
use App\Models\TimPBL;

class DashboardDosenController extends Controller
{
    public function index()
    {
        $dosen = auth('dosen')->user();
        $periodeAktif = PeriodePBL::where('status', 'Aktif')->first();

        if (!$periodeAktif) {
            return view('dosen.dashboard-dosen', [
                'timCount' => 0,
                'mahasiswaCount' => 0,
                'totalTim' => 0,
                'labels' => [],
                'data' => [],
                'jumlahSudahUts' => 0,
                'jumlahBelumUts' => 0,
                'jumlahSudahUas' => 0,
                'jumlahBelumUas' => 0,
                'mahasiswaSudahDinilai' => 0,
                'mahasiswaBelumDinilai' => 0,
            ]);
        }

        $kelasDosen = $this->getKelasDosen($dosen->nim, $periodeAktif->id);
        $timCodes = $this->getTimCodes($kelasDosen, $periodeAktif->id);
        $timCount = count($timCodes);

        $mahasiswaCount = $this->getJumlahMahasiswaUnik($timCodes);
        $lineChart = $this->getLineChartData($timCodes);
        $barChart = $this->getBarChartData($timCodes);
        $pieChart = $this->getPieChartData($timCodes, $dosen->nim, $periodeAktif->id);

        return view('dosen.dashboard-dosen', array_merge([
            'timCount' => $timCount,
            'mahasiswaCount' => $mahasiswaCount,
            'totalTim' => $timCount,
        ], $lineChart, $barChart, $pieChart));
    }

    private function getKelasDosen($dosenNim, $periodeId)
    {
        return Pengampu::where('dosen_id', $dosenNim)
            ->where('periode_id', $periodeId)
            ->pluck('kelas_id');
    }

    private function getTimCodes($kelasIds, $periodeId)
    {
        return TimPBL::whereIn('kelas', $kelasIds)
            ->where('periode', $periodeId)
            ->pluck('kode_tim')
            ->toArray();
    }

    private function getJumlahMahasiswaUnik($timCodes)
    {
        return AnggotaTimPbl::whereIn('kode_tim', $timCodes)
            ->distinct('nim')
            ->count('nim');
    }

    private function getLineChartData($timCodes)
    {
        $rawData = Logbook::whereIn('kode_tim', $timCodes)
            ->select('kode_tim')
            ->selectRaw('SUM(progress) as total_progress')
            ->groupBy('kode_tim')
            ->get();

        $grouped = $rawData->groupBy(function ($item) {
            $rounded = floor($item->total_progress / 10) * 10;
            return $rounded > 100 ? 100 : $rounded;
        })->map(fn($group) => count($group))->sortKeys();

        $labels = range(0, 100, 10);
        $data = collect($labels)->map(fn($label) => $grouped[$label] ?? 0)->values();

        return compact('labels', 'data');
    }

    private function getBarChartData($timCodes)
    {
        $jumlahTim = count($timCodes);

        $timSudahUts = PelaporanUTS::whereIn('kode_tim', $timCodes)->pluck('kode_tim')->unique();
        $timSudahUas = PelaporanUAS::whereIn('kode_tim', $timCodes)->pluck('kode_tim')->unique();

        return [
            'jumlahSudahUts' => $timSudahUts->count(),
            'jumlahBelumUts' => $jumlahTim - $timSudahUts->count(),
            'jumlahSudahUas' => $timSudahUas->count(),
            'jumlahBelumUas' => $jumlahTim - $timSudahUas->count(),
        ];
    }

    private function getPieChartData($timCodes, $dosenNim, $periodeId)
    {
        $anggotaMahasiswa = AnggotaTimPbl::whereIn('kode_tim', $timCodes)
            ->pluck('nim')
            ->unique();

        $pengampuIds = Pengampu::where('dosen_id', $dosenNim)
            ->where('periode_id', $periodeId)
            ->pluck('id');

        $mahasiswaSudahDinilai = NilaiMahasiswa::whereIn('nim', $anggotaMahasiswa)
            ->whereIn('pengampu_id', $pengampuIds)
            ->distinct('nim')
            ->count('nim');

        $mahasiswaBelumDinilai = $anggotaMahasiswa->count() - $mahasiswaSudahDinilai;

        return compact('mahasiswaSudahDinilai', 'mahasiswaBelumDinilai');
    }
}
