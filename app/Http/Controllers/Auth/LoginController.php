<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Metode login tetap digunakan seperti sebelumnya
    public function login(Request $request)
    {
        // Validasi nim, password, dan role
        $validated = $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string|in:admin,mahasiswa,manajerproyek', // Validasi role
        ]);

        // Autentikasi menggunakan nim dan password
        if (Auth::attempt([
            'nim' => $validated['nim'],
            'password' => $validated['password'],
        ])) {
            // Cek role pengguna
            $user = Auth::user();
            if ($user->role === $validated['role']) {
                // Pengalihan berdasarkan role
                switch ($user->role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'mahasiswa':
                        return redirect()->route('mahasiswa.dashboard');
                    case 'manajerproyek':
                        return redirect()->route('manajerproyek..dashboard');
                    default:
                        Auth::logout(); // Jika role tidak sesuai, logout
                        return back()->withErrors(['role' => 'Role tidak sesuai!']);
                }
            } else {
                Auth::logout(); // Jika role tidak sesuai, logout
                return back()->withErrors(['role' => 'Role tidak sesuai!']);
            }
        }

        return back()->withErrors(['nim' => 'NIM atau password salah!']);
    }
}
