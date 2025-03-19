<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\DashboardController;
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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post'); // Route untuk proses login
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');


Route::middleware(['auth:sanctum'])->group(function () {
    // Admin
    // Dashboard
    Route::get('admin/dashboard', function () {
        return view('admin.dashboard-admin');
    })->name('admin.dashboard');

    // Tim PBL
    Route::get('admin/menu/tim-pbl', function () {
        return view('admin.tim-pbl.timpbl');
    })->name('admin.timpbl');
    Route::get('admin/menu/tim-pbl/tambah', function () {
        return view('admin.tim-pbl.tambah-timpbl');
    })->name('admin.tambah-timpbl');
    Route::get('admin/menu/tim-pbl/edit', function () {
        return view('admin.tim-pbl.edit-timpbl');
    })->name('admin.edit-timpbl');

    // Periode PBL
    Route::get('admin/menu/periode-pbl', function () {
        return view('admin.periode-pbl.periodepbl');
    })->name('admin.periodepbl');
    Route::get('admin/menu/periode-pbl/tambah', function () {
        return view('admin.periode-pbl.tambah-periodepbl');
    })->name('admin.tambah-periodepbl');
    Route::get('admin/menu/periode-pbl/edit', function () {
        return view('admin.periode-pbl.edit-periodepbl');
    })->name('admin.edit-periodepbl');

    // Tahapan Pelaksanaan Proyek
    Route::get('admin/menu/tahapan-pelaksanaan-proyek', function () {
        return view('admin.tahapan-pelaksanaan.tahapan-pelaksanaan');
    })->name('admin.tahapanpelaksanaan');
    Route::get('admin/menu/tahapan-pelaksanaan-proyek/tambah', function () {
        return view('admin.tahapan-pelaksanaan.tambah-tahapan-pelaksanaan');
    })->name('admin.tambah-tahapanpelaksanaan');
    Route::get('admin/menu/tahapan-pelaksanaan-proyek/edit', function () {
        return view('admin.tahapan-pelaksanaan.edit-tahapan-pelaksanaan');
    })->name('admin.edit-tahapanpelaksanaan');

    // Matkul
    Route::get('admin/menu/master-data/mata-kuliah', function () {
        return view('admin.mata-kuliah.matkul');
    })->name('admin.matkul');
    Route::get('admin/menu/master-data/mata-kuliah/tambah', function () {
        return view('admin.mata-kuliah.tambah-matkul');
    })->name('admin.tambah-matkul');
    Route::get('admin/menu/master-data/mata-kuliah/edit', function () {
        return view('admin.mata-kuliah.edit-matkul');
    })->name('admin.edit-matkul');

    // Mahasiswa
    Route::get('admin/menu/master-data/akun-mahasiswa', function () {
        return view('admin.akun-mahasiswa.mahasiswa');
    })->name('admin.mahasiswa');
    Route::get('admin/menu/master-data/akun-mahasiswa/tambah', function () {
        return view('admin.akun-mahasiswa.tambah-mahasiswa');
    })->name('admin.tambah-mahasiswa');
    Route::get('admin/menu/master-data/akun-mahasiswa/edit', function () {
        return view('admin.akun-mahasiswa.edit-mahasiswa');
    })->name('admin.edit-mahasiswa');

    // Dosen
    Route::get('admin/menu/master-data/akun-dosen', function () {
        return view('admin.akun-dosen.dosen');
    })->name('admin.dosen');
    Route::get('admin/menu/master-data/akun-dosen/tambah', function () {
        return view('admin.akun-dosen.tambah-dosen');
    })->name('admin.tambah-dosen');
    Route::get('admin/menu/master-data/akun-dosen/edit', function () {
        return view('admin.akun-dosen.edit-dosen');
    })->name('admin.edit-dosen');
});
