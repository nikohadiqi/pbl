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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']); // Route untuk proses login

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');

    Route::get('/dashboard/mahasiswa', function () {
        return view('dashboard.mahasiswa');
    })->name('mahasiswa.dashboard');

    Route::get('/dashboard/dosen', function () {
        return view('dashboard.dosen');
    })->name('dosen.dashboard');
});
