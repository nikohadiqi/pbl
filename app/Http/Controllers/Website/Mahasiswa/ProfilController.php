<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilController extends Controller
{
    public function index()
    {
        return view('mahasiswa.profil');
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

        $auth = Auth::user();

        if (!Hash::check($request->get('old_password'), $auth->password)) {
            return back()->with('error', "Password lama salah!");
        }

        if (strcmp($request->get('old_password'), $request->new_password) == 0) {
            return back()->with("error", "Password baru tidak boleh sama dengan password saat ini!");
        }

        $user = User::find($auth->id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        Alert::success('Berhasil!', 'Password berhasil diubah!');
        return redirect()->route('mahasiswa.profil');
    }
}
