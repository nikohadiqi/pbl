<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user login secara umum (via guard 'web') dan role-nya mahasiswa
        if (!Auth::check() || Auth::user()->role !== 'dosen') {
            return redirect()->route('login')->withErrors([
                'akses' => 'Akses ditolak! Silakan login sebagai Dosen.'
            ]);
        }

        return $next($request);
    }
}
