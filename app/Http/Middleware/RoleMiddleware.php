<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan pengguna sudah login dan memiliki role yang sesuai
        if (!Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'Unauthorized action.'); // Akses ditolak jika role tidak sesuai
        }

        return $next($request); // Lanjutkan jika role sesuai
    }
}
