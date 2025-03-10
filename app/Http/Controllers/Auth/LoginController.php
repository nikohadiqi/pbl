<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
    
        $user = User::where('nim', $validated['nim'])->first();
    
        if ($user && Hash::check($validated['password'], $user->password)) {
            if ($user->role === $validated['role']) {
                $token = $user->createToken('YourAppName')->plainTextToken;
    
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'token' => $token,
                    'user' => [
                        'id' => $user->id,
                        'nim' => $user->nim,
                        'nama' => $user->name,
                        'role' => $user->role
                    ]
                ], 200);
            }
    
            return response()->json(['success' => false, 'message' => 'Role tidak sesuai dengan akun ini!'], 401);
        }
    
        return response()->json(['success' => false, 'message' => 'NIM atau password salah!'], 401);
    }
    
    //     // Cek user berdasarkan NIM
    //     $user = User::where('nim', $validated['nim'])->first();

    //     // Cek apakah user ditemukan dan password valid
    //     if ($user && Hash::check($validated['password'], $user->password)) {
    //         // Pastikan role sesuai dengan yang dimasukkan
    //         if ($user->role === $validated['role']) {
    //             // Generate token untuk user
    //             $token = $user->createToken('YourAppName')->plainTextToken;

    //             // Set token ke dalam session atau response JSON
    //             $request->session()->put('token', $token);

    //             // Arahkan pengguna ke dashboard sesuai dengan role
    //             switch ($user->role) {
    //                 case 'admin':
    //                     return redirect()->route('admin.dashboard');
    //                 case 'mahasiswa':
    //                     return redirect()->route('mahasiswa.dashboard');
    //                 case 'dosen':
    //                     return redirect()->route('dosen.dashboard');
    //                 default:
    //                     return back()->withErrors(['role' => 'Role tidak sesuai']);
    //             }
    //         }

    //         return back()->withErrors(['role' => 'Role tidak sesuai dengan akun ini!']);
    //     }

    //     // Jika login gagal
    //     return back()->withErrors(['nim' => 'NIM atau password salah!']);
    // }

    // // Admin Dashboard
    // public function adminDashboard()
    // {
    //     return view('dashboard.admin'); // Halaman Dashboard Admin
    // }

    // // Mahasiswa Dashboard
    // public function mahasiswaDashboard()
    // {
    //     return view('dashboard.mahasiswa'); // Halaman Dashboard Mahasiswa
    // }

    // // Dosen Dashboard
    // public function dosenDashboard()
    // {
    //     return view('dashboard.dosen'); // Halaman Dashboard Dosen
    // }

    // Logout Method
    public function logout(Request $request)
    {
        // Hapus token dan logout
        Auth::logout();
        $request->session()->flush(); // Hapus session
        return redirect('/login'); // Redirect ke halaman login
    }
}
