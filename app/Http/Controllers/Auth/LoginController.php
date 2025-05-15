<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AkunMahasiswa;
use App\Models\AkunDosen;
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
        $remember = $request->has('remember'); // Remember Login

        $user = User::where('nim', $validated['nim'])->first();

        if ($user && Hash::check($validated['password'], $user->password) && $user->role == 'admin') {
            $token = $user->createToken('YourAppName')->plainTextToken;
            $request->session()->put('token', $token);

            Auth::guard('web')->login($user, $remember); // Pakai remember

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['nim' => 'NIP atau password salah.']);
    }

   public function loginMahasiswa(Request $request, $validated)
{
    $remember = $request->has('remember');

    $mahasiswa = AkunMahasiswa::where('nim', $validated['nim'])->first();

    if ($mahasiswa && Hash::check($validated['password'], $mahasiswa->password) && $mahasiswa->role == 'mahasiswa') {
        // Logout guard lain sebelum login mahasiswa
        Auth::guard('web')->logout();
        Auth::guard('dosen')->logout();

        Auth::guard('mahasiswa')->login($mahasiswa, $remember);

        return redirect()->route('mahasiswa.dashboard');
    }

    return back()->withErrors(['nim' => 'NIM atau password salah.']);
}


  public function loginDosen(Request $request, $validated)
{
    $remember = $request->has('remember');

    $dosen = AkunDosen::where('nim', $validated['nim'])->first();

    if ($dosen && Hash::check($validated['password'], $dosen->password) && $dosen->role == 'dosen') {
        // Logout guard lain sebelum login dosen
        Auth::guard('web')->logout();
        Auth::guard('mahasiswa')->logout();

        Auth::guard('dosen')->login($dosen, $remember);

        return redirect()->route('dosen.dashboard');
    }

    return back()->withErrors(['nim' => 'NIP atau password salah.']);
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
        return view('dosen.dashboard-dosen');
    }

 public function logout(Request $request)
{
    Auth::guard('web')->logout();
    Auth::guard('mahasiswa')->logout();
    Auth::guard('dosen')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Logout berhasil.');
}

}
