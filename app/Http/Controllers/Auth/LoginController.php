<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AkunMahasiswa;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string|in:admin,mahasiswa,dosen',
        ]);

        switch ($validated['role']) {
            case 'admin':
                return $this->loginAdmin($request, $validated);
            
            case 'mahasiswa':
                return $this->loginMahasiswa($request, $validated);
            
            case 'dosen':
                return $this->loginDosen($request, $validated);
            
            default:
                return back()->withErrors(['role' => 'Role tidak valid.']);
        }
    }

    public function loginAdmin(Request $request, $validated)
    {
        $user = User::where('nim', $validated['nim'])->first();

        if ($user && Hash::check($validated['password'], $user->password) && $user->role == 'admin') {
            $token = $user->createToken('YourAppName')->plainTextToken;
            $request->session()->put('token', $token);
            Auth::login($user);

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['nim' => 'NIM atau password salah.']);
    }

    public function loginMahasiswa(Request $request, $validated)
    {
        $mahasiswa = AkunMahasiswa::where('nim', $validated['nim'])->first();

        if ($mahasiswa && Hash::check($validated['password'], $mahasiswa->password)) {

            // Gunakan guard khusus mahasiswa agar tidak tertukar dengan User
            Auth::guard('mahasiswa')->login($mahasiswa);

            return redirect()->route('mahasiswa.dashboard');
        }

        return back()->withErrors(['nim' => 'NIM atau password salah.']);
    }

    public function loginDosen(Request $request, $validated)
    {
        $user = User::where('nim', $validated['nim'])->first();

        if ($user && Hash::check($validated['password'], $user->password) && $user->role == 'dosen') {
            $token = $user->createToken('YourAppName')->plainTextToken;
            $request->session()->put('token', $token);
            Auth::login($user);

            return redirect()->route('dosen.dashboard');
        }

        return back()->withErrors(['nim' => 'NIM atau password salah.']);
    }

    public function adminDashboard()
    {
        return view('admin.dashboard-admin');
    }

    public function mahasiswaDashboard()
    {
        return view('dashboard.mahasiswa');
    }

    public function dosenDashboard()
    {
        return view('dashboard.dosen');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        if (Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}
