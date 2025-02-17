<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\PeriodePBLController;
use App\Http\Controllers\Admin\TimPBLController;
use App\Http\Controllers\Auth\LoginController;


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
});
