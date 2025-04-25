<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\Admin\DosenController;
use App\Http\Controllers\Website\Admin\MahasiswaController;
use App\Http\Controllers\Website\Admin\MataKuliahController;
use App\Http\Controllers\Website\Admin\PeriodePBLController;
use App\Http\Controllers\Website\Admin\TPP4Controller;
use App\Http\Controllers\Website\Admin\TPP5Controller;
use App\Http\Controllers\Website\Admin\TimPBLController;

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

    // TIM PBL
    Route::prefix('admin/tim-pbl')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [TimPBLController::class, 'index'])->name('admin.timpbl');
        Route::get('/tambah', [TimPBLController::class, 'create'])->name('admin.tambah-timpbl');
        Route::post('/store', [TimPBLController::class, 'store'])->name('admin.timpbl.store');
        Route::get('/edit/{id_tim}', [TimPBLController::class, 'edit'])->name('admin.edit-timpbl');
        Route::put('/update/{id_tim}', [TimPBLController::class, 'update'])->name('admin.timpbl.update');
        Route::delete('/delete/{id_tim}', [TimPBLController::class, 'destroy'])->name('admin.timpbl.delete');
        Route::get('/cari-ketua', [TimPBLController::class, 'cariKetua'])->name('admin.timpbl.cariKetua');
    });

    // Periode PBL
    Route::prefix('menu/master-data/periode-pbl')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [PeriodePBLController::class, 'index'])->name('admin.periodepbl');
        Route::get('/tambah', [PeriodePBLController::class, 'create'])->name('admin.tambah-periodepbl');
        Route::post('/simpan', [PeriodePBLController::class, 'store'])->name('admin.periodepbl.store');
        Route::get('/edit/{id}', [PeriodePBLController::class, 'edit'])->name('admin.edit-periodepbl');
        Route::patch('/update/{id}', [PeriodePBLController::class, 'update'])->name('admin.periodepbl.update');
        Route::delete('/hapus/{id}', [PeriodePBLController::class, 'destroy'])->name('admin.periodepbl.delete');
        Route::delete('/hapus-massal', [PeriodePBLController::class, 'bulkDelete'])->name('admin.periodepbl.bulk-delete');
    });

    // TPP SEMESTER 4
    Route::prefix('admin/tahapan-pelaksanaan/semester4')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [TPP4Controller::class, 'index'])->name('admin.tahapanpelaksanaan-sem4');
        Route::get('/tambah', [TPP4Controller::class, 'create'])->name('admin.tambah-tahapanpelaksanaan-sem4');
        Route::post('/store', [TPP4Controller::class, 'store'])->name('admin.tahapanpelaksanaan.store');
        Route::get('/edit/{id}', [TPP4Controller::class, 'edit'])->name('admin.edit-tahapanpelaksanaan-sem4');
        Route::put('/update/{id}', [TPP4Controller::class, 'update'])->name('admin.tahapanpelaksanaan.update');
        Route::delete('/delete/{id}', [TPP4Controller::class, 'destroy'])->name('admin.tahapanpelaksanaan.delete');
    });

    // TPP SEMESTER 5
    Route::prefix('admin/tahapan-pelaksanaan/semester5')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [TPP5Controller::class, 'index'])->name('admin.tahapanpelaksanaan-sem5');
        Route::get('/tambah', [TPP5Controller::class, 'create'])->name('admin.tambah-tahapanpelaksanaan-sem5');
        Route::post('/store', [TPP5Controller::class, 'store'])->name('admin.tahapanpelaksanaan.store');
        Route::get('/edit/{id}', [TPP5Controller::class, 'edit'])->name('admin.edit-tahapanpelaksanaan-sem5');
        Route::put('/update/{id}', [TPP5Controller::class, 'update'])->name('admin.tahapanpelaksanaan.update');
        Route::delete('/delete/{id}', [TPP5Controller::class, 'destroy'])->name('admin.tahapanpelaksanaan.delete');
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
    Route::get('/edit/{nim}', [MahasiswaController::class, 'edit'])->name('admin.edit-mahasiswa');
    Route::patch('/update/{nim}', [MahasiswaController::class, 'update'])->name('admin.update-mahasiswa');
    Route::delete('/hapus/{nim}', [MahasiswaController::class, 'destroy'])->name('admin.delete-mahasiswa');
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

    // Tahapan Pelaksanaan Proyek
    Route::prefix('menu/semester-4')->group(function () {
        // RPP
        Route::view('/rpp', 'mahasiswa.semester4.rpp.rencana-proyek')->name('mahasiswa.rpp.sem4');
        // Logbook
        // Pelaporan
    });

});
