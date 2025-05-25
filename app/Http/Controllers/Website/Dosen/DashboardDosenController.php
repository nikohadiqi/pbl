<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Anggota_Tim_Pbl;
use App\Models\Logbook;
use App\Models\NilaiMahasiswa;
use App\Models\PelaporanUAS;
use App\Models\PelaporanUTS;
use App\Models\Pengampu;
use App\Models\TimPbl;

class DashboardDosenController extends Controller
{
    public function index()
    {
        $dosen = auth('dosen')->user();

        $kelasDosen = $this->getKelasDosen($dosen->nim);
        $timCodes = $this->getTimCodes($kelasDosen);
        $timCount = count($timCodes);

        $mahasiswaCount = $this->getJumlahMahasiswaUnik($timCodes);
        $lineChart = $this->getLineChartData($timCodes);
        $barChart = $this->getBarChartData($timCodes);
        $pieChart = $this->getPieChartData($timCodes, $dosen->nim);

        return view('dosen.dashboard-dosen', array_merge([
            'timCount' => $timCount,
            'mahasiswaCount' => $mahasiswaCount,
            'totalTim' => $timCount,
        ], $lineChart, $barChart, $pieChart));
    }

    private function getKelasDosen($dosenNim)
    {
        return Pengampu::where('dosen_id', $dosenNim)->pluck('kelas_id');
    }

    private function getTimCodes($kelasIds)
    {
        return TimPbl::whereIn('kelas', $kelasIds)->pluck('kode_tim')->toArray();
    }

    private function getJumlahMahasiswaUnik($timCodes)
    {
        return Anggota_Tim_Pbl::whereIn('kode_tim', $timCodes)->distinct('nim')->count('nim');
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

    private function getPieChartData($timCodes, $dosenNim)
    {
        $anggotaMahasiswa = Anggota_Tim_Pbl::whereIn('kode_tim', $timCodes)->pluck('nim')->unique();
        $pengampuIds = Pengampu::where('dosen_id', $dosenNim)->pluck('id');

        $mahasiswaSudahDinilai = NilaiMahasiswa::whereIn('nim', $anggotaMahasiswa)
            ->whereIn('pengampu_id', $pengampuIds)
            ->distinct('nim')
            ->count('nim');

        $mahasiswaBelumDinilai = $anggotaMahasiswa->count() - $mahasiswaSudahDinilai;

        return compact('mahasiswaSudahDinilai', 'mahasiswaBelumDinilai');
    }
}
