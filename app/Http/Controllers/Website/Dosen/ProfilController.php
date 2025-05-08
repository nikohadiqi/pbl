<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use App\Models\AkunDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilController extends Controller
{
    public function index()
    {
        return view('dosen.profil');
    }

    public function editPassword()
    {
        return view('dosen.profil-ubah-password');
    }

    public function updatePassword(Request $request)
    {
        // Validate input fields
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ], [
            'confirm_password.same' => 'Konfirmasi password tidak sama dengan password baru.',
            'new_password.min' => 'Password baru minimal harus 6 karakter.',
        ]);

        // Get the authenticated Dosen user
        $auth = Auth::guard('dosen')->user(); // Use the correct guard for 'dosen'

        // Check if the old password matches the current password in the database
        if (!Hash::check($request->get('old_password'), $auth->password)) {
            return back()->with('error', "Password lama salah!");
        }

        // Check if the old password is the same as the new password
        if (strcmp($request->get('old_password'), $request->new_password) == 0) {
            return back()->with("error", "Password baru tidak boleh sama dengan password saat ini!");
        }

        // Update the password
        $auth->password = Hash::make($request->new_password);
        $auth->save();

        // Display a success alert
        Alert::success('Berhasil!', 'Password berhasil diubah!');
        
        // Redirect to the profile page
        return redirect()->route('dosen.profil');
    }
}
