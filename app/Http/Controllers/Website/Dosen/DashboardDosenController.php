<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardDosenController extends Controller
{
    public function index() {
        return view('dosen.dashboard-dosen');
    }
}
