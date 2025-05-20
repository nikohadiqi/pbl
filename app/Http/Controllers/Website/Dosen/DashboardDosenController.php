<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\TimPbl;
use Illuminate\Http\Request;

class DashboardDosenController extends Controller
{
    public function index() {
        $timCount = TimPbl::count();
        $mahasiswaCount = Mahasiswa::count();
        $dosenCount = Dosen::count();
        return view('dosen.dashboard-dosen', compact('timCount', 'mahasiswaCount', 'dosenCount'));
    }
}
