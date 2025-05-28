<?php

use App\Models\AnggotaTimPbl;
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

        $kodeTim = AnggotaTimPbl::where('nim', $nim)
            ->whereHas('tim', function ($q) use ($periodeAktif) {
                $q->where('periode', $periodeAktif->id);
            })
            ->value('kode_tim');

        return $kodeTim;
    }
}
