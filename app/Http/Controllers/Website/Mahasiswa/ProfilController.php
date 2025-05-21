<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AkunMahasiswa;
use App\Models\TimPbl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilController extends Controller
{
    public function index()
    {
        $akun = Auth::guard('mahasiswa')->user(); // akun_mahasiswa
        $mahasiswa = $akun->mahasiswa; // relasi ke data_mahasiswa

        // Ambil data dari tim
        $timPbl = TimPbl::with(['manproFK'])
                ->where('kode_tim', $akun->kode_tim)
                ->first();

        return view('mahasiswa.profil', compact('akun', 'mahasiswa', 'timPbl'));
    }

    public function editPassword()
    {
        return view('mahasiswa.profil-ubah-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ], [
            'confirm_password.same' => 'Konfirmasi password tidak sama dengan password baru.',
            'new_password.min' => 'Password baru minimal harus 6 karakter.',
        ]);

        $auth = Auth::guard('mahasiswa')->user();


        if (!Hash::check($request->get('old_password'), $auth->password)) {
            return back()->with('error', "Password lama salah!");
        }

        if (strcmp($request->get('old_password'), $request->new_password) == 0) {
            return back()->with("error", "Password baru tidak boleh sama dengan password saat ini!");
        }

        $user = AkunMahasiswa::find($auth->id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        Alert::success('Berhasil!', 'Password berhasil diubah!');
        return redirect()->route('mahasiswa.profil');
    }
}
