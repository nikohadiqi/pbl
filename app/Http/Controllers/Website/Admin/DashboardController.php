<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\TimPBL;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $timPBLCount = TimPBL::count();
        $mahasiswaCount = Mahasiswa::count();
        $dosenCount = Dosen::count();

        return view('admin.dashboard-admin', compact(
            'timPBLCount', 'mahasiswaCount', 'dosenCount',
        ));
    }
}
