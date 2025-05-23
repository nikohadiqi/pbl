<?php

use App\Models\Anggota_Tim_Pbl;
use App\Models\PeriodePbl;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getKodeTimByAuth')) {
    function getKodeTimByAuth()
    {
        $nim = Auth::guard('mahasiswa')->user()->nim ?? null;
        $periodeAktif = PeriodePBL::where('status', 'Aktif')->first();

        if (!$periodeAktif) {
            return null;
        }

        $kodeTim = Anggota_Tim_Pbl::where('nim', $nim)
            ->whereHas('tim', function ($q) use ($periodeAktif) {
                $q->where('periode', $periodeAktif->id);
            })
            ->value('kode_tim');

        return $kodeTim;
    }
}
