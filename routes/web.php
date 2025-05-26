<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MahasiswaRegisterController;

use App\Http\Controllers\Website\Admin\DashboardController;
use App\Http\Controllers\Website\Admin\ProfilController;
use App\Http\Controllers\Website\Admin\PeriodePBLController;
use App\Http\Controllers\Website\Admin\MataKuliahController;
use App\Http\Controllers\Website\Admin\KelasController;
use App\Http\Controllers\Website\Admin\MahasiswaController;
use App\Http\Controllers\Website\Admin\DosenController;
use App\Http\Controllers\Website\Admin\PengampuController;
use App\Http\Controllers\Website\Admin\TahapanPelaksanaanProyekController;

use App\Http\Controllers\Website\Mahasiswa\DashboardMahasiswaController;
use App\Http\Controllers\Website\Mahasiswa\ProfilController as MahasiswaProfilController;
use App\Http\Controllers\Website\Mahasiswa\RencanaProyekController;
use App\Http\Controllers\Website\Mahasiswa\LogbookController;
use App\Http\Controllers\Website\Mahasiswa\PelaporanController;

use App\Http\Controllers\Website\Dosen\DashboardDosenController;
use App\Http\Controllers\Website\Dosen\ProfilController as DosenProfilController;
use App\Http\Controllers\Website\Dosen\DaftarTimController;
use App\Http\Controllers\Website\Dosen\ValidasiController;
use App\Http\Controllers\Website\Dosen\PenilaianController;

// ============================
// Route
// ============================
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post'); // Route untuk proses login
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
// Register
Route::get('/register', [MahasiswaRegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register-tim', [MahasiswaRegisterController::class, 'register'])->name('register.tim');
Route::get('register/search/mahasiswa', [MahasiswaController::class, 'searchMahasiswa'])->middleware(['throttle:10,1']);
Route::get('register/search/manpro', [PengampuController::class, 'searchManpro'])->middleware(['throttle:10,1']);
Route::get('register/tunggu-validasi', function () {
    $tim = session('tim');
    if (!$tim) {
        return redirect()->route('register')->with('error', 'Data tidak ditemukan. Silakan daftar ulang.');
    }
    return view('auth.tunggu-validasi', compact('tim'));
})->name('register.tunggu-validasi');

// ============================
// Route Akun Admin
// ============================
Route::middleware(['auth:web', 'role:web,admin'])->group(function () {
    // Dashboard
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Profil
    Route::prefix('admin/profil')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('admin.profil');
        Route::get('/ubah-password', [ProfilController::class, 'editPassword'])->name('admin.profil.ubah-password');
        Route::post('/ubah-password', [ProfilController::class, 'updatePassword'])->name('admin.profil.update-password');
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
        Route::patch('/selesai/{id}', [PeriodePBLController::class, 'selesai'])->name('admin.periodepbl.selesai');
        Route::patch('/aktifkan/{id}', [PeriodePBLController::class, 'aktifkan'])->name('admin.periodepbl.aktifkan');
    });

    // Tahapan Pelaksanaan Proyek
    Route::prefix('admin/tahapan-pelaksanaan-proyek')->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/', [TahapanPelaksanaanProyekController::class, 'index'])->name('admin.tpp');
        Route::post('/simpan', [TahapanPelaksanaanProyekController::class, 'store'])->name('admin.tpp.store');
        Route::delete('/reset', [TahapanPelaksanaanProyekController::class, 'reset'])->name('admin.tpp.reset');
        Route::post('/import', [TahapanPelaksanaanProyekController::class, 'import'])->name('admin.tpp.import');
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
        Route::get('/', [PengampuController::class, 'manage'])->name('admin.pengampu');
        Route::post('/manage', [PengampuController::class, 'manageStore'])->name('admin.pengampu.manage.store');
    });
});

// ============================
// Route Akun Mahasiswa
// ============================
Route::middleware(['auth:mahasiswa'])->group(function () {

    // Dashboard Mahasiswa
    Route::get('mahasiswa/dashboard', [DashboardMahasiswaController::class, 'index'])->name('mahasiswa.dashboard');

    // Profil Mahasiswa
    Route::prefix('mahasiswa/profil')->group(function () {
        Route::get('/', [MahasiswaProfilController::class, 'index'])->name('mahasiswa.profil');
        Route::get('/ubah-password', [MahasiswaProfilController::class, 'editPassword'])->name('mahasiswa.profil.ubah-password');
        Route::post('/ubah-password', [MahasiswaProfilController::class, 'updatePassword'])->name('mahasiswa.profil.update-password');
    });

    // RPP
    Route::prefix('mahasiswa/rpp')->group(function () {
        Route::prefix('rencana-proyek')->group(function () {
            Route::get('/', [RencanaProyekController::class, 'create'])->name('mahasiswa.rpp.rencana-proyek.create');
            Route::post('/simpan', [RencanaProyekController::class, 'store'])->name('mahasiswa.rpp.rencana-proyek.store');
            Route::post('/tahapan', [RencanaProyekController::class, 'storeTahapanPelaksanaan'])->name('mahasiswa.rpp.tahapan-pelaksanaan.store');
            Route::post('/kebutuhan', [RencanaProyekController::class, 'storeKebutuhanPeralatan'])->name('mahasiswa.rpp.kebutuhan-peralatan.store');
            Route::post('/tantangan', [RencanaProyekController::class, 'storeTantangan'])->name('mahasiswa.rpp.tantangan.store');
            Route::post('/biaya', [RencanaProyekController::class, 'storeBiaya'])->name('mahasiswa.rpp.biaya.store');
            Route::post('/estimasi', [RencanaProyekController::class, 'storeEstimasi'])->name('mahasiswa.rpp.estimasi.store');
            Route::get('/rencana-proyek/export', [RencanaProyekController::class, 'exportWord'])->name('mahasiswa.rpp.rencana-proyek.export');

        });
    });

    // Logbook Mahasiswa
    Route::prefix('mahasiswa/logbook')->group(function () {
        Route::get('/', [LogbookController::class, 'index'])->name('mahasiswa.logbook');
        Route::get('/isi-logbook', [LogbookController::class, 'create'])->name('mahasiswa.logbook.create');
        Route::post('/isi-logbook', [LogbookController::class, 'store'])->name('mahasiswa.logbook.store');
    });

    // Pelaporan PBL
    Route::prefix('mahasiswa/laporan-pbl')->group(function () {
        Route::get('/', [PelaporanController::class, 'index'])->name('mahasiswa.pelaporan-pbl');
        // Form Laporan UTS
        Route::post('/form-laporan-uts', [PelaporanController::class, 'storeUTS'])->name('mahasiswa.pelaporan-pbl.laporan-uts.store');
        // Form Laporan UAS
        Route::post('/form-laporan-uas', [PelaporanController::class, 'storeUAS'])->name('mahasiswa.pelaporan-pbl.laporan-uas.store');
    });
});

// ============================
// Route Akun Dosen
// ============================
Route::middleware(['auth:dosen'])->group(function () {

    // Dashboard Dosen
    Route::get('/dosen/dashboard', [DashboardDosenController::class, 'index'])->name('dosen.dashboard');

    // Profil Dosen
    Route::prefix('dosen/profil')->group(function () {
        Route::get('/', [DosenProfilController::class, 'index'])->name('dosen.profil');
        Route::get('/ubah-password', [DosenProfilController::class, 'editPassword'])->name('dosen.profil.ubah-password');
        Route::post('/ubah-password', [DosenProfilController::class, 'updatePassword'])->name('dosen.profil.update-password');
    });

    // Validasi Tim PBL
    Route::prefix('/dosen/validasi-tim-pbl')->group(function () {
        Route::get('/', [ValidasiController::class, 'index'])->name('dosen.validasi-tim');
        Route::post('/approve/{kode_tim}', [ValidasiController::class, 'approve'])->name('dosen.validasi-tim.approve');
        Route::post('/reject/{kode_tim}', [ValidasiController::class, 'reject'])->name('dosen.validasi-tim.reject');
        Route::get('/riwayat-tim-pbl', [ValidasiController::class, 'history'])->name('dosen.validasi-tim.riwayat-tim-pbl');
    });

    // Daftar Tim PBL
    Route::prefix('/dosen/daftar-tim-pbl')->group(function () {
        Route::get('/', [DaftarTimController::class, 'index'])->name('dosen.daftar-tim');
        Route::get('/logbook/{tim}', [DaftarTimController::class, 'lihatLogbookTim'])->name('dosen.daftar-tim.logbook');
        Route::get('/laporan/{tim}', [DaftarTimController::class, 'lihatLaporanTim'])->name('dosen.daftar-tim.laporan');

        Route::get('/penilaian-mahasiswa', function () {
            return view('dosen.daftar-tim.penilaian-timpbl');
        })->name('dosen.daftar-tim.penilaian');
    });

    Route::prefix('/dosen/penilaian-mahasiswa')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('dosen.penilaian');
        Route::get('/rubrik-penilaian/{nim}', [PenilaianController::class, 'show'])->name('dosen.penilaian.beri-nilai');
        Route::post('/rubrik-penilaian/{nim}', [PenilaianController::class, 'store'])->name('dosen.penilaian.simpan-nilai');
        Route::get('/export', [PenilaianController::class, 'exportExcel'])->name('penilaian.export');
    });

});


