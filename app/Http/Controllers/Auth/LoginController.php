<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AkunMahasiswa;
use App\Models\AkunDosen;
use App\Models\AnggotaTimPbl;
use App\Models\Dosen;
use App\Models\Pengampu;
use App\Models\PeriodePBL;
use App\Models\regMahasiswa;
use App\Models\TimPBL;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showLoginDosenForm()
    {
        return view('auth.login-dosen');
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
            // $token = $user->createToken('YourAppName')->plainTextToken;
            // $request->session()->put('token', $token);

            Auth::guard('web')->login($user, $remember); // Pakai remember

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['nim' => 'NIP atau password salah.']);
    }

    public function loginMahasiswa(Request $request, $validated)
    {
        $remember = $request->has('remember');

        // Cari akun mahasiswa
        $mahasiswa = AkunMahasiswa::where('nim', $validated['nim'])->first();

        if ($mahasiswa && Hash::check($validated['password'], $mahasiswa->password) && $mahasiswa->role === 'mahasiswa') {

            // Ambil semua kode_tim dari mahasiswa
            $kodeTimList = AnggotaTimPbl::where('nim', $validated['nim'])->pluck('kode_tim');

            // Cari tim aktif yang sesuai
            $timAktif = regMahasiswa::whereIn('kode_tim', $kodeTimList)
                ->where('status', 'approved')
                ->whereHas('periodeFK', function ($query) {
                    $query->where('status', '!=', 'Selesai');
                })
                ->latest('created_at')
                ->first();

            if (!$timAktif) {
                return back()->withErrors(['nim' => 'Anda belum terdaftar di tim aktif yang valid pada periode berjalan.']);
            }

            // Login
            Auth::guard('web')->logout();
            Auth::guard('dosen')->logout();
            Auth::guard('mahasiswa')->login($mahasiswa, $remember);

            // Simpan informasi tim ke session jika perlu
            session(['tim' => $timAktif]);

            return redirect()->route('mahasiswa.dashboard');
        }

        return back()->withErrors(['nim' => 'NIM atau password salah.']);
    }

    public function loginDosen(Request $request, $validated)
    {
        $remember = $request->has('remember');

        $akunDosen = AkunDosen::where('nim', $validated['nim'])->first();

        if ($akunDosen && Hash::check($validated['password'], $akunDosen->password) && $akunDosen->role == 'dosen') {
            // Ambil periode aktif
            $periodeAktif = PeriodePBL::where('status', 'Aktif')->first();

            if (!$periodeAktif) {
                return back()->withErrors(['nim' => 'Tidak ada periode aktif.']);
            }

            // Ambil data dosen dari nip (yang disimpan di akunDosen.id)
            $dosen = Dosen::where('nip', $akunDosen->nim)->first();

            if (!$dosen) {
                return back()->withErrors(['nim' => 'Data dosen tidak ditemukan.']);
            }

            // Cek apakah dosen adalah pengampu di periode aktif
            $isPengampu = Pengampu::where('dosen_id', $dosen->nip)
                ->where('periode_id', $periodeAktif->id)
                ->exists();

            if (!$isPengampu) {
                return back()->withErrors(['nim' => 'Anda bukan pengampu pada periode aktif.']);
            }

            // Logout guard lain sebelum login dosen
            Auth::guard('web')->logout();
            Auth::guard('mahasiswa')->logout();

            Auth::guard('dosen')->login($akunDosen, $remember);

            return redirect()->route('dosen.dashboard');
        }

        return back()->withErrors(['nim' => 'NIP atau password salah.']);
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
