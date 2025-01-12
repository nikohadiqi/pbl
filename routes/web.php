<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {
    // Dashboard untuk admin
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    // Dashboard untuk mahasiswa
    Route::get('/mahasiswa/dashboard', [DashboardController::class, 'mahasiswaDashboard'])->name('mahasiswa.dashboard');

    // Dashboard untuk manajer proyek
    Route::get('/manajerproyek/dashboard', [DashboardController::class, 'manajerProyekDashboard'])->name('manajerproyek.dashboard');
});

