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
        // Menampilkan Data Tim
        $timpbl = TimPBL::with(['anggota.mahasiswaFK']) // include nama mahasiswa
            ->latest()
            ->take(5)
            ->get();
        // Menampilkan Data Dosen Pengampu Terbaru
        $datadosen = Pengampu::with(['kelasFk', 'dosenFk', 'matkulFK', 'periodeFK'])
            ->latest()
            ->take(5) // Mengambil 5 data terbaru
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
