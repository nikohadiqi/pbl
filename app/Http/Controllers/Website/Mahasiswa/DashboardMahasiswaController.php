<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    public function index() {
        return view('mahasiswa.dashboard-mahasiswa');
    }

    public function laporan_pbl() {
        return view('mahasiswa.semester4.pelaporan.pelaporan-pbl');
    }
}
