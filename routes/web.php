<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\Admin\DosenController;
use App\Http\Controllers\Website\Admin\MahasiswaController;
use App\Http\Controllers\Website\Admin\MataKuliahController;


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


// Route Akun Admin
Route::middleware(['auth:sanctum'])->group(function () {
    // Dashboard
    Route::get('admin/dashboard', function () {
        return view('admin.dashboard-admin');
    })->name('admin.dashboard');

    // Tim PBL
    Route::prefix('menu/tim-pbl')->group(function () {
        Route::view('/', 'admin.tim-pbl.timpbl')->name('admin.timpbl');
        Route::view('/tambah', 'admin.tim-pbl.tambah-timpbl')->name('admin.tambah-timpbl');
        Route::view('/edit', 'admin.tim-pbl.edit-timpbl')->name('admin.edit-timpbl');
    });

    // Periode PBL
    Route::prefix('menu/periode-pbl')->group(function () {
        Route::view('/', 'admin.periode-pbl.periodepbl')->name('admin.periodepbl');
        Route::view('/tambah', 'admin.periode-pbl.tambah-periodepbl')->name('admin.tambah-periodepbl');
        Route::view('/edit', 'admin.periode-pbl.edit-periodepbl')->name('admin.edit-periodepbl');
    });

    // Tahapan Pelaksanaan Proyek
    Route::prefix('menu/tahapan-pelaksanaan-proyek')->group(function () {
        // Semester 4
        Route::view('/semester-4', 'admin.tahapan-pelaksanaan.semester4.tahapan-pelaksanaan')->name('admin.tahapanpelaksanaan-sem4');
        Route::view('semester-4/tambah', 'admin.tahapan-pelaksanaan.semester4.tambah-tahapan-pelaksanaan')->name('admin.tambah-tahapanpelaksanaan-sem4');
        Route::view('semester-4/edit', 'admin.tahapan-pelaksanaan.semester4.edit-tahapan-pelaksanaan')->name('admin.edit-tahapanpelaksanaan-sem4');
        // Semester 5
        Route::view('/semester-5', 'admin.tahapan-pelaksanaan.semester5.tahapan-pelaksanaan')->name('admin.tahapanpelaksanaan-sem5');
        Route::view('semester-5/tambah', 'admin.tahapan-pelaksanaan.semester5.tambah-tahapan-pelaksanaan')->name('admin.tambah-tahapanpelaksanaan-sem5');
        Route::view('semester-5/edit', 'admin.tahapan-pelaksanaan.semester5.edit-tahapan-pelaksanaan')->name('admin.edit-tahapanpelaksanaan-sem5');
    });

Route::prefix('menu/master-data/mata-kuliah')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/', [MataKuliahController::class, 'index'])->name('admin.matkul');
    Route::get('/tambah', [MataKuliahController::class, 'create'])->name('admin.tambah-matkul');
    Route::post('/simpan', [MataKuliahController::class, 'store'])->name('admin.matkul.store');
    Route::get('/edit/{id}', [MataKuliahController::class, 'edit'])->name('admin.edit-matkul');
    Route::patch('/update/{id}', [MataKuliahController::class, 'update'])->name('admin.update-matkul');
    Route::delete('/hapus/{id}', [MataKuliahController::class, 'destroy'])->name('admin.hapus-matkul');
});
 // Akun Mahasiswa
 Route::prefix('menu/master-data/akun-mahasiswa')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/', [MahasiswaController::class, 'index'])->name('admin.mahasiswa');
    Route::get('/tambah', [MahasiswaController::class, 'create'])->name('admin.tambah-mahasiswa');
    Route::post('/simpan', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');  // ✅ Route untuk simpan
    Route::get('/edit/{id}', [MahasiswaController::class, 'edit'])->name('admin.edit-mahasiswa');
    Route::patch('/update/{id}', [MahasiswaController::class, 'update'])->name('admin.update-mahasiswa');
    Route::delete('/hapus/{id}', [MahasiswaController::class, 'destroy'])->name('admin.delete-mahasiswa');
    });

    Route::prefix('menu/master-data/akun-dosen')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [DosenController::class, 'index'])->name('admin.dosen'); // Tampilkan daftar dosen
        Route::get('/tambah', [DosenController::class, 'create'])->name('admin.tambah-dosen'); // Form tambah dosen
        Route::post('/store', [DosenController::class, 'store'])->name('admin.dosen.store'); // Simpan data dosen
        Route::get('/edit/{id}', [DosenController::class, 'edit'])->name('admin.edit-dosen');
        Route::put('/update/{id}', [DosenController::class, 'update'])->name('admin.dosen.update');
        Route::delete('/delete/{id}', [DosenController::class, 'destroy'])->name('admin.dosen.delete'); // Hapus dosen
    });

});

// Route Akun Mahasiswa
Route::prefix('mahasiswa')->middleware(['auth:sanctum'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('mahasiswa.dashboard-mahasiswa');
    })->name('mahasiswa.dashboard');

    // RPP
    Route::get('/menu/rencana-pelaksanaan-proyek', function () {
        return view('mahasiswa.rpp.rencana-proyek');
    })->name('mahasiswa.rpp');
});
