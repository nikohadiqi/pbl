<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashboard untuk admin
    public function adminDashboard()
    {
        return view('dashboard.admin'); // View untuk dashboard admin
    }

    // Dashboard untuk mahasiswa
    public function mahasiswaDashboard()
    {
        return view('dashboard.mahasiswa'); // View untuk dashboard mahasiswa
    }

    // Dashboard untuk manajer proyek
    public function manajerproyekDashboard()
    {
        return view('dashboard.manajerproyek'); // View untuk dashboard manajer proyek
    }
}
