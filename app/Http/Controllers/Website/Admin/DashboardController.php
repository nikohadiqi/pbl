<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Pengampu;
use App\Models\TimPBL;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $timCount = TimPBL::count();
        $mahasiswaCount = Mahasiswa::count();
        $dosenCount = Dosen::count();
        // Menampilkan Data Tim dengan status 'approved' dan periode Aktif
        $timpbl = TimPBL::with(['anggota.mahasiswaFK', 'rencanaProyek', 'logbooks'])
            ->where('status', 'approved')
            ->whereHas('periodeFK', function ($query) {
                $query->where('status', 'Aktif');
            })
            ->latest()
            ->take(5)
            ->get();

        // Menampilkan Data Dosen Pengampu Terbaru dari periode Aktif
        $datadosen = Pengampu::with(['kelasFk', 'dosenFk', 'matkulFK', 'periodeFK'])
            ->whereHas('periodeFK', function ($query) {
                $query->where('status', 'Aktif');
            })
            ->latest()
            ->take(5)
            ->get();
        return view('admin.dashboard-admin', compact(
            'timCount',
            'mahasiswaCount',
            'dosenCount',
            'timpbl',
            'datadosen'
        ));
    }
}
