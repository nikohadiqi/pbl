<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AkunMahasiswa;
use Illuminate\Support\Facades\Session as FacadesSession;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login'); // Halaman Login
    }

    // Proses login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string|in:admin,mahasiswa,dosen',
        ]);

        // Check role and redirect to the respective login function
        switch ($validated['role']) {
            case 'admin':
                return $this->loginAdmin($request, $validated);
            case 'mahasiswa':
                return $this->loginMahasiswa($request, $validated);
            case 'dosen':
                return $this->loginDosen($request, $validated);
            default:
                return back()->withErrors(['role' => 'Role tidak sesuai!']);
        }
    }

    // Login untuk Admin
    public function loginAdmin(Request $request, $validated)
    {
        $user = User::where('nim', $validated['nim'])->first();

        // Cek apakah admin ditemukan dan password valid
        if ($user && Hash::check($validated['password'], $user->password) && $user->role == 'admin') {
            // Generate token untuk autentikasi (opsional jika pakai API)
            $token = $user->createToken('YourAppName')->plainTextToken;
            $request->session()->put('token', $token);

            // Simpan informasi user di session untuk kebutuhan autentikasi
            auth()->login($user);

            // Redirect ke dashboard admin
            return redirect()->route('admin.dashboard');
        }

        // Jika login gagal
        return back()->withErrors(['nim' => 'NIM atau password salah!']);
    }

    // Login untuk Mahasiswa
    public function loginMahasiswa(Request $request, $validated)
    {
        $mahasiswa = AkunMahasiswa::where('nim', $validated['nim'])->first();

        // Cek apakah mahasiswa ditemukan dan password valid
        if ($mahasiswa && Hash::check($validated['password'], $mahasiswa->password)) {
            // Login mahasiswa
            auth()->guard('web')->login($mahasiswa);

            // Simpan session atau token jika perlu
            $token = $mahasiswa->createToken('mahasiswa-token')->plainTextToken;
            $request->session()->put('token', $token);

            // Redirect ke dashboard mahasiswa
            return redirect()->route('mahasiswa.dashboard');
        }

        // Jika login gagal
        return back()->withErrors(['nim' => 'NIM atau password salah!']);
    }

    // Login untuk Dosen
    public function loginDosen(Request $request, $validated)
    {
        $user = User::where('nim', $validated['nim'])->first();

        // Cek apakah dosen ditemukan dan password valid
        if ($user && Hash::check($validated['password'], $user->password) && $user->role == 'dosen') {
            // Generate token untuk autentikasi
            $token = $user->createToken('YourAppName')->plainTextToken;
            $request->session()->put('token', $token);

            // Simpan informasi user di session untuk kebutuhan autentikasi
            auth()->login($user);

            // Redirect ke dashboard dosen
            return redirect()->route('dosen.dashboard');
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
