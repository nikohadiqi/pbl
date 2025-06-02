<?php

use App\Models\AnggotaTimPbl;
use App\Models\PeriodePBL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

if (!function_exists('getKodeTimByAuth')) {
    function getKodeTimByAuth(): ?string
    {
        try {
            // Pengecekan auth lebih ketat
            if (!Auth::guard('mahasiswa')->check()) {
                throw new \Exception('User not authenticated');
            }

            $user = Auth::guard('mahasiswa')->user();
            if (!$user || !$user->nim) {
                throw new \Exception('Invalid user data');
            }

            $periodeAktif = PeriodePBL::where('status', 'Aktif')->first();
            if (!$periodeAktif) {
                throw new \Exception('No active period found');
            }

            // Pastikan relasi 'tim' ada di model AnggotaTimPbl
            return AnggotaTimPbl::with('tim')
                ->where('nim', $user->nim)
                ->whereHas('tim', function ($q) use ($periodeAktif) {
                    $q->where('periode', $periodeAktif->id);
                })
                ->value('kode_tim');

        } catch (\Exception $e) {
            Log::error('Helper Error: ' . $e->getMessage());
            return null;
        }
    }
}
