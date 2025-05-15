<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $guard
     * @param  string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard, $role)
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('login');
        }

        $user = Auth::guard($guard)->user();

        if ($user->role !== $role) {
            // Role tidak sesuai, bisa redirect atau abort 403
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
