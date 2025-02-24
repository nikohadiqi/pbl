<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\PeriodePBLController;
use App\Http\Controllers\Admin\TimPBLController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\TahapanPelaksanaanProyekController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Mahasiswa\RencanaProyekController;
use App\Http\Controllers\Mahasiswa\TahapanPelaksaanController;
use App\Http\Controllers\Mahasiswa\KebutuhanPeralatanController;
use App\Http\Controllers\Mahasiswa\TantanganController;
use App\Http\Controllers\Mahasiswa\EstimasiWaktuController;
use App\Http\Controllers\Mahasiswa\BiayaProyekController;
use App\Http\Controllers\Mahasiswa\TimProyekController;
use App\Http\Controllers\Mahasiswa\CapaianPembelajaranController;
use App\Http\Controllers\Mahasiswa\LogbookController;

Route::post('/login', [LoginController::class, 'login']);

Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {

    // 🔹 Rute Dosen
    Route::post('dosen', [DosenController::class, 'create']); // Tambah Dosen
    Route::get('dosen', [DosenController::class, 'index']); // Ambil Semua Dosen
    Route::get('dosen/{id}', [DosenController::class, 'show']); // Ambil Detail Dosen
    Route::put('dosen/{id}', [DosenController::class, 'update']); // Update Dosen
    Route::delete('dosen/{id}', [DosenController::class, 'delete']); // Hapus Dosen
    Route::delete('dosen/bulk-delete', [DosenController::class, 'bulkDelete']); // Bulk Hapus Dosen

    // 🔹 Rute Mahasiswa
    Route::post('mahasiswa', [MahasiswaController::class, 'create']); 
    Route::get('mahasiswa', [MahasiswaController::class, 'index']); 
    Route::get('mahasiswa/{id}', [MahasiswaController::class, 'show']); 
    Route::put('mahasiswa/{id}', [MahasiswaController::class, 'update']); 
    Route::delete('mahasiswa/{id}', [MahasiswaController::class, 'delete']); 
    Route::delete('mahasiswa/bulk-delete', [MahasiswaController::class, 'bulkDelete']); 

    // 🔹 Rute Periode PBL
    Route::post('periode-pbl', [PeriodePBLController::class, 'create']); 
    Route::get('periode-pbl', [PeriodePBLController::class, 'index']); 
    Route::get('periode-pbl/{id}', [PeriodePBLController::class, 'show']); 
    Route::put('periode-pbl/{id}', [PeriodePBLController::class, 'update']); 
    Route::delete('periode-pbl/{id}', [PeriodePBLController::class, 'delete']); 
    Route::delete('periode-pbl/bulk-delete', [PeriodePBLController::class, 'bulkDelete']); 

    // 🔹 Rute Tim PBL
    Route::post('tim-pbl', [TimPBLController::class, 'create']); // Tambah Tim PBL
    Route::get('tim-pbl', [TimPBLController::class, 'index']); // Ambil Semua Tim PBL
    Route::get('tim-pbl/{id}', [TimPBLController::class, 'show']); // Detail Tim PBL
    Route::put('tim-pbl/{id}', [TimPBLController::class, 'update']); // Update Tim PBL
    Route::delete('tim-pbl/{id}', [TimPBLController::class, 'delete']); // Hapus Tim PBL
    Route::delete('tim-pbl/bulk-delete', [TimPBLController::class, 'bulkDelete']); // Bulk Hapus Tim PBL

    // tahapan pelaksaan proyek
    Route::get('/tahapan-proyek', [TahapanPelaksanaanProyekController::class, 'index']);
    Route::post('/tahapan-proyek', [TahapanPelaksanaanProyekController::class, 'store']);
    Route::get('/tahapan-proyek/{id}', [TahapanPelaksanaanProyekController::class, 'show']);
    Route::put('/tahapan-proyek/{id}', [TahapanPelaksanaanProyekController::class, 'update']);
    Route::delete('/tahapan-proyek/{id}', [TahapanPelaksanaanProyekController::class, 'destroy']);
    Route::post('/tahapan-proyek/bulk-delete', [TahapanPelaksanaanProyekController::class, 'bulkDelete']);

    // data matakuliah
    Route::get('/mata-kuliah', [MataKuliahController::class, 'index']);
    Route::post('/mata-kuliah', [MataKuliahController::class, 'store']);
    Route::get('/mata-kuliah/{id}', [MataKuliahController::class, 'show']);
    Route::put('/mata-kuliah/{id}', [MataKuliahController::class, 'update']);
    Route::delete('/mata-kuliah/{id}', [MataKuliahController::class, 'destroy']);
    Route::post('/mata-kuliah/bulk-delete', [MataKuliahController::class, 'bulkDelete']);
});

    Route::prefix('mahasiswa')->group(function () {
    //RPP 
    Route::get('/rencana-proyek', [RencanaProyekController::class, 'index']);
    Route::post('/rencana-proyek', [RencanaProyekController::class, 'store']);
    Route::get('/rencana-proyek/{id}', [RencanaProyekController::class, 'show']);
    Route::put('/rencana-proyek/{id}', [RencanaProyekController::class, 'update']);
    Route::delete('/rencana-proyek/{id}', [RencanaProyekController::class, 'destroy']);
    Route::post('/rencana-proyek/bulk-delete', [RencanaProyekController::class, 'bulkDelete']);

    //tahapan pelaksaan mahasiswa
    Route::get('/tahapan-pelaksaan', [TahapanPelaksaanController::class, 'index']);
    Route::post('/tahapan-pelaksaan', [TahapanPelaksaanController::class, 'store']);
    Route::get('/tahapan-pelaksaan/{id}', [TahapanPelaksaanController::class, 'show']);
    Route::put('/tahapan-pelaksaan/{id}', [TahapanPelaksaanController::class, 'update']);
    Route::delete('/tahapan-pelaksaan/{id}', [TahapanPelaksaanController::class, 'destroy']);
    Route::post('/tahapan-pelaksaan/bulk-delete', [TahapanPelaksaanController::class, 'bulkDelete']);

    // Kebutuhan Peralatan
    Route::get('/kebutuhan-peralatan', [KebutuhanPeralatanController::class, 'index']);
    Route::post('/kebutuhan-peralatan', [KebutuhanPeralatanController::class, 'store']);
    Route::get('/kebutuhan-peralatan/{id}', [KebutuhanPeralatanController::class, 'show']);
    Route::put('/kebutuhan-peralatan/{id}', [KebutuhanPeralatanController::class, 'update']);
    Route::delete('/kebutuhan-peralatan/{id}', [KebutuhanPeralatanController::class, 'destroy']);
    Route::post('/kebutuhan-peralatan/bulk-delete', [KebutuhanPeralatanController::class, 'bulkDelete']);

    // Tantangan
    Route::get('/tantangan', [TantanganController::class, 'index']);
    Route::post('/tantangan', [TantanganController::class, 'store']);
    Route::get('/tantangan/{id}', [TantanganController::class, 'show']);
    Route::put('/tantangan/{id}', [TantanganController::class, 'update']);
    Route::delete('/tantangan/{id}', [TantanganController::class, 'destroy']);
    Route::post('/tantangan/bulk-delete', [TantanganController::class, 'bulkDelete']);

    // Estimasi Waktu
    Route::get('/estimasi-waktu', [EstimasiWaktuController::class, 'index']);
    Route::post('/estimasi-waktu', [EstimasiWaktuController::class, 'store']);
    Route::get('/estimasi-waktu/{id}', [EstimasiWaktuController::class, 'show']);
    Route::put('/estimasi-waktu/{id}', [EstimasiWaktuController::class, 'update']);
    Route::delete('/estimasi-waktu/{id}', [EstimasiWaktuController::class, 'destroy']);
    Route::post('/estimasi-waktu/bulk-delete', [EstimasiWaktuController::class, 'bulkDelete']);

    // Biaya Proyek
    Route::get('/biaya-proyek', [BiayaProyekController::class, 'index']);
    Route::post('/biaya-proyek', [BiayaProyekController::class, 'store']);
    Route::get('/biaya-proyek/{id}', [BiayaProyekController::class, 'show']);
    Route::put('/biaya-proyek/{id}', [BiayaProyekController::class, 'update']);
    Route::delete('/biaya-proyek/{id}', [BiayaProyekController::class, 'destroy']);
    Route::post('/biaya-proyek/bulk-delete', [BiayaProyekController::class, 'bulkDelete']);

    // Tim Proyek
    Route::get('/tim-proyek', [TimProyekController::class, 'index']);
    Route::post('/tim-proyek', [TimProyekController::class, 'store']);
    Route::get('/tim-proyek/{id}', [TimProyekController::class, 'show']);
    Route::put('/tim-proyek/{id}', [TimProyekController::class, 'update']);
    Route::delete('/tim-proyek/{id}', [TimProyekController::class, 'destroy']);
    Route::post('/tim-proyek/bulk-delete', [TimProyekController::class, 'bulkDelete']);

    // Capaian Pembelajaran
    Route::get('/capaian-pembelajaran', [CapaianPembelajaranController::class, 'index']);
    Route::post('/capaian-pembelajaran', [CapaianPembelajaranController::class, 'store']);
    Route::get('/capaian-pembelajaran/{id}', [CapaianPembelajaranController::class, 'show']);
    Route::put('/capaian-pembelajaran/{id}', [CapaianPembelajaranController::class, 'update']);
    Route::delete('/capaian-pembelajaran/{id}', [CapaianPembelajaranController::class, 'destroy']);
    Route::post('/capaian-pembelajaran/bulk-delete', [CapaianPembelajaranController::class, 'bulkDelete']);

    Route::get('/logbook', [LogbookController::class, 'index']);
    Route::post('/logbook', [LogbookController::class, 'store']);
    Route::get('/logbook/{id}', [LogbookController::class, 'show']);
    Route::put('/logbook/{id}', [LogbookController::class, 'update']);
    Route::delete('/logbook/{id}', [LogbookController::class, 'destroy']);
    Route::post('/logbook/bulk-delete', [LogbookController::class, 'bulkDelete']);
});
