<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session as FacadesSession;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Halaman Login
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string|in:admin,mahasiswa,dosen',
        ]);

        // Cari user berdasarkan NIM
        $user = User::where('nim', $validated['nim'])->first();

        // Cek apakah user ditemukan dan password valid
        if ($user && Hash::check($validated['password'], $user->password)) {
            // Pastikan role sesuai dengan yang dipilih di form login
            if ($user->role !== $validated['role']) {
                return back()->withErrors(['role' => 'Role tidak sesuai dengan akun ini!']);
            }

            // Generate token untuk autentikasi (opsional jika pakai API)
            $token = $user->createToken('YourAppName')->plainTextToken;
            $request->session()->put('token', $token);

            // Simpan informasi user di session untuk kebutuhan autentikasi
            auth()->login($user);

            // Redirect ke dashboard sesuai role
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
                'dosen' => redirect()->route('dosen.dashboard'),
                default => back()->withErrors(['role' => 'Role tidak sesuai!'])
            };
        }

        // Jika login gagal
        return back()->withErrors(['nim' => 'NIM atau password salah!']);
    }


    // Admin Dashboard
    public function adminDashboard()
    {
        return view('admin.dashboard-admin'); // Halaman Dashboard Admin
    }

    // Mahasiswa Dashboard
    public function mahasiswaDashboard()
    {
        return view('dashboard.mahasiswa'); // Halaman Dashboard Mahasiswa
    }

    // Dosen Dashboard
    public function dosenDashboard()
    {
        return view('dashboard.dosen'); // Halaman Dashboard Dosen
    }

    // Logout Method
    public function logout(Request $request)
    {
        if (auth()->check()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
