<?php

use App\Http\Controllers\Auth\MahasiswaRegisterController;
use App\Http\Controllers\Auth\LoginMahasiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Website\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\Admin\DosenController;
use App\Http\Controllers\Website\Admin\KelasController;
use App\Http\Controllers\Website\Admin\MahasiswaController;
use App\Http\Controllers\Website\Admin\MataKuliahController;
use App\Http\Controllers\Website\Admin\PengampuController;
use App\Http\Controllers\Website\Admin\PeriodePBLController;
use App\Http\Controllers\Website\Admin\ProfilController;
use App\Http\Controllers\Website\Admin\TPP4Controller;
use App\Http\Controllers\Website\Admin\TPP5Controller;
use App\Http\Controllers\Website\Admin\TimPBLController;
use App\Http\Controllers\Website\Mahasiswa\DashboardMahasiswaController;
use App\Http\Controllers\Website\Mahasiswa\RencanaProyekController;
use App\Http\Controllers\Website\Mahasiswa\LogbookController;
use App\Http\Controllers\Website\Mahasiswa\ProfilController as MahasiswaProfilController;

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
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Profil
    Route::get('admin/profil', [ProfilController::class, 'index'])->name('admin.profil');
    Route::get('/admin/profil/ubah-password', [ProfilController::class, 'editPassword'])->name('admin.profil.ubah-password');
    Route::post('/admin/profil/ubah-password', [ProfilController::class, 'updatePassword'])->name('admin.profil.update-password');

    // TIM PBL
    Route::prefix('admin/master-data/tim-pbl')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [TimPBLController::class, 'index'])->name('admin.timpbl');
        Route::get('/tambah', [TimPBLController::class, 'create'])->name('admin.timpbl.tambah');
        Route::post('/store', [TimPBLController::class, 'store'])->name('admin.timpbl.store');
        Route::get('/edit/{id_tim}', [TimPBLController::class, 'edit'])->name('admin.timpbl.edit');
        Route::put('/update/{id_tim}', [TimPBLController::class, 'update'])->name('admin.timpbl.update');
        Route::delete('/delete/{id_tim}', [TimPBLController::class, 'destroy'])->name('admin.timpbl.delete');
        Route::get('/cari-ketua', [TimPBLController::class, 'cariKetua'])->name('admin.timpbl.cariKetua');
    });

    // Periode PBL
    Route::prefix('menu/master-data/periode-pbl')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [PeriodePBLController::class, 'index'])->name('admin.periodepbl');
        Route::get('/tambah', [PeriodePBLController::class, 'create'])->name('admin.periodepbl.tambah');
        Route::post('/simpan', [PeriodePBLController::class, 'store'])->name('admin.periodepbl.store');
        Route::get('/edit/{id}', [PeriodePBLController::class, 'edit'])->name('admin.periodepbl.edit');
        Route::PUT('/update/{id}', [PeriodePBLController::class, 'update'])->name('admin.periodepbl.update');
        Route::delete('/hapus/{id}', [PeriodePBLController::class, 'destroy'])->name('admin.periodepbl.delete');
        Route::delete('/hapus-massal', [PeriodePBLController::class, 'bulkDelete'])->name('admin.periodepbl.bulk-delete');
    });

    // TPP SEMESTER 4
    Route::prefix('admin/tahapan-pelaksanaan/semester4')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [TPP4Controller::class, 'index'])->name('admin.tahapanpelaksanaan-sem4');
        Route::get('/tambah', [TPP4Controller::class, 'create'])->name('admin.tahapanpelaksanaan-sem4.tambah');
        Route::post('/store', [TPP4Controller::class, 'store'])->name('admin.tahapanpelaksanaan-sem4.store');
        Route::get('/edit/{id}', [TPP4Controller::class, 'edit'])->name('admin.tahapanpelaksanaan-sem4.edit');
        Route::put('/update/{id}', [TPP4Controller::class, 'update'])->name('admin.tahapanpelaksanaan-sem4.update');
        Route::delete('/delete/{id}', [TPP4Controller::class, 'destroy'])->name('admin.tahapanpelaksanaan-sem4.delete');
    });

    // TPP SEMESTER 5
    Route::prefix('admin/tahapan-pelaksanaan/semester5')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [TPP5Controller::class, 'index'])->name('admin.tahapanpelaksanaan-sem5');
        Route::get('/tambah', [TPP5Controller::class, 'create'])->name('admin.tahapanpelaksanaan-sem5.tambah');
        Route::post('/store', [TPP5Controller::class, 'store'])->name('admin.tahapanpelaksanaan-sem5.store');
        Route::get('/edit/{id}', [TPP5Controller::class, 'edit'])->name('admin.tahapanpelaksanaan-sem5.edit');
        Route::put('/update/{id}', [TPP5Controller::class, 'update'])->name('admin.tahapanpelaksanaan-sem5.update');
        Route::delete('/delete/{id}', [TPP5Controller::class, 'destroy'])->name('admin.tahapanpelaksanaan-sem5.delete');
    });

    // Mata Kuliah
    Route::prefix('menu/master-data/mata-kuliah')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [MataKuliahController::class, 'index'])->name('admin.matkul');
        Route::get('/tambah', [MataKuliahController::class, 'create'])->name('admin.matkul.tambah');
        Route::post('/simpan', [MataKuliahController::class, 'store'])->name('admin.matkul.store');
        Route::get('/edit/{id}', [MataKuliahController::class, 'edit'])->name('admin.matkul.edit');
        Route::PUT('/update/{id}', [MataKuliahController::class, 'update'])->name('admin.matkul.update');
        Route::delete('/hapus/{id}', [MataKuliahController::class, 'destroy'])->name('admin.matkul.delete');
    });

    // Data Kelas
    Route::prefix('menu/master-data/kelas')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('admin.kelas');
        Route::get('/tambah', [KelasController::class, 'create'])->name('admin.kelas.tambah');
        Route::post('/simpan', [KelasController::class, 'store'])->name('admin.kelas.store');
        Route::get('/edit/{kelas}', [KelasController::class, 'edit'])->name('admin.kelas.edit');
        Route::PUT('/update/{kelas}', [KelasController::class, 'update'])->name('admin.kelas.update');
        Route::delete('/hapus/{kelas}', [KelasController::class, 'destroy'])->name('admin.kelas.delete');
    });

    // Data Mahasiswa
    Route::prefix('menu/master-data/data-mahasiswa')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [MahasiswaController::class, 'index'])->name('admin.mahasiswa');
        Route::get('/tambah', [MahasiswaController::class, 'create'])->name('admin.mahasiswa.tambah');
        Route::post('/simpan', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');  // ✅ Route untuk simpan
        Route::get('/edit/{nim}', [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
        Route::PUT('/update/{nim}', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
        Route::delete('/hapus/{nim}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.delete');
        Route::post('/import-mahasiswa', [MahasiswaController::class, 'import'])->name('admin.mahasiswa.import'); //impor
    });

    // Data Dosen
    Route::prefix('menu/master-data/data-dosen')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [DosenController::class, 'index'])->name('admin.dosen'); // Tampilkan daftar dosen
        Route::get('/tambah', [DosenController::class, 'create'])->name('admin.dosen.tambah'); // Form tambah dosen
        Route::post('/store', [DosenController::class, 'store'])->name('admin.dosen.store'); // Simpan data dosen
        Route::get('/edit/{nip}', [DosenController::class, 'edit'])->name('admin.dosen.edit');
        Route::put('/update/{nip}', [DosenController::class, 'update'])->name('admin.dosen.update');
        Route::delete('/delete/{nip}', [DosenController::class, 'destroy'])->name('admin.dosen.delete'); // Hapus dosen
        Route::post('/import-dosen', [DosenController::class, 'import'])->name('admin.dosen.import'); // Impor
    });

    // Pengampu MK / Manpro
    Route::prefix('menu/master-data/pengampu')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [PengampuController::class, 'index'])->name('admin.pengampu');
        Route::get('/tambah', [PengampuController::class, 'create'])->name('admin.pengampu.tambah');
        Route::post('/simpan', [PengampuController::class, 'store'])->name('admin.pengampu.store');
        Route::get('/edit/{id}', [PengampuController::class, 'edit'])->name('admin.pengampu.edit');
        Route::PUT('/update/{id}', [PengampuController::class, 'update'])->name('admin.pengampu.update');
        Route::delete('/hapus/{id}', [PengampuController::class, 'destroy'])->name('admin.pengampu.delete');
    });

});

// Route Akun Mahasiswa
Route::prefix('mahasiswa')->middleware(['auth:sanctum'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('mahasiswa.dashboard-mahasiswa');
    })->name('mahasiswa.dashboard');

    // Profil
    Route::get('/profil', [MahasiswaProfilController::class, 'index'])->name('mahasiswa.profil');
    Route::get('/profil/ubah-password', [MahasiswaProfilController::class, 'editPassword'])->name('mahasiswa.profil.ubah-password');
    Route::post('/profil/ubah-password', [MahasiswaProfilController::class, 'updatePassword'])->name('mahasiswa.profil.update-password');

    // Tahapan Pelaksanaan Proyek
//     Route::prefix('menu/mahasiswa/semester4/rpp/rencana-proyek')->middleware(['auth:sanctum', 'mahasiswa'])->group(function () {
//         Route::get('/', [RencanaProyekController::class, 'create'])->name('mahasiswa.rpp.rencana-proyek.create');
//         Route::post('/', [RencanaProyekController::class, 'store'])->name('mahasiswa.rpp.rencana-proyek.store');
//         Route::put('/{id}', [RencanaProyekController::class, 'update'])->name('mahasiswa.rpp.rencana-proyek.update');
// });

    // Tahapan Pelaksanaan Proyek
    Route::resource('menu/mahasiswa/semester4/rpp/rencana-proyek', RencanaProyekController::class)->names([
        'create' => 'mahasiswa.rpp.rencana-proyek.create',
        'store' => 'mahasiswa.rpp.rencana-proyek.store',
        'update' => 'mahasiswa.rpp.rencana-proyek.update'
    ]);


    // Logbook
    Route::prefix('semester-4/logbook')->middleware(['auth:sanctum', 'mahasiswa'])->group(function () {
        Route::get('/', [LogbookController::class, 'index'])->name('mahasiswa.logbook');
        Route::get('/isi-logbook', [LogbookController::class, 'create'])->name('mahasiswa.logbook.create');
    });
    // Pelaporan
    Route::prefix('semester-4/laporan-pbl')->middleware(['auth:sanctum', 'mahasiswa'])->group(function () {
        Route::get('/', [DashboardMahasiswaController::class, 'laporan_pbl'])->name('mahasiswa.pelaporan-pbl');
        Route::get('/form-laporan', [DashboardMahasiswaController::class, 'form_laporan'])->name('mahasiswa.pelaporan-pbl.create');
    });
 });
