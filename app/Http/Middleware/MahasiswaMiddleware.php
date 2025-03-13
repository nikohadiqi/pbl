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
        // Pastikan pengguna sudah login dan memiliki peran 'admin'
        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak! Hanya mahasiswa yang diperbolehkan.'
            ], 403);
        }

        return $next($request);
    }
}
