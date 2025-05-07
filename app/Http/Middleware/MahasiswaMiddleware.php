<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user login lewat guard mahasiswa
        if (!Auth::guard('mahasiswa')->check()) {
            return redirect()->route('login')->withErrors([
                'akses' => 'Akses ditolak! Silakan login sebagai mahasiswa.'
            ]);
        }

        return $next($request);
    }
}
