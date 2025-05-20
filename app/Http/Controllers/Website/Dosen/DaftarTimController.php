<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\PeriodePBL;
use App\Models\TimPbl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarTimController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('dosen')->user();

        $timPBL = collect();    // default kosong

        // Data dropdown kelas dan periode
        $kelasList = Kelas::pluck('kelas');
        $periodeList = PeriodePBL::where('status', 'aktif')->get();

        // Jika dosen login adalah manpro
        if ($user && $user->is_manajer_proyek) {
            $query = TimPbl::with(['anggota.mahasiswaFK', 'manproFK', 'periodeFK', 'rencanaProyek'])
                ->where('status', 'approved');

            // Jika ada filter, gunakan
            if ($request->filled('kelas')) {
                $query->where('kelas', $request->kelas);
            }

            if ($request->filled('tahun')) {
                $query->where('periode', $request->tahun);
            }

            // Jika tidak ada filter, tampilkan hanya tim yang dia ampu
            if (!$request->filled('kelas') && !$request->filled('tahun')) {
                $query->where('manpro', $user->nim);
            }

            $timPBL = $query->get();
        }

        // Jika dosen login BUKAN manpro
        elseif ($request->filled('kelas') && $request->filled('tahun')) {
            $timPBL = TimPbl::with(['anggota.mahasiswaFK', 'manproFK', 'periodeFK', 'rencanaProyek'])
                ->where('status', 'approved')
                ->where('kelas', $request->kelas)
                ->where('periode', $request->tahun)
                ->get();
        }

        return view('dosen.daftar-tim.daftar-timpbl', compact('timPBL', 'kelasList', 'periodeList'));
    }
}
