<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AkunMahasiswa;
use App\Models\AnggotaTimPbl;
use App\Models\regMahasiswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MahasiswaRegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input anggota tim
        $request->validate([
            'kelas' => 'required|string',
            'kelompok' => 'required|integer',
            'anggota' => 'required|array',
            'anggota.*' => 'string|unique:akun_mahasiswa,nim', // Validasi setiap nim
        ]);

        // Buat kode tim berdasarkan kelas dan kelompok
        $kode_tim = strtoupper($request->kelas) . $request->kelompok;

        // Logging kode tim
        Log::info('Kode tim yang dibuat:', ['kode_tim' => $kode_tim]);

        // Buat data tim jika belum ada
        $tim = regMahasiswa::firstOrCreate([
            'kode_tim' => $kode_tim,
            'kelas' => $request->kelas,
            'kelompok' => $request->kelompok,
        ]);

        // Ambil anggota yang telah dimasukkan dalam request
        $anggota_nims = $request->anggota;

        // Loop untuk membuat akun mahasiswa baru
        foreach ($anggota_nims as $nim) {
            Log::info('Membuat akun mahasiswa:', [
                'kode_tim' => $kode_tim,
                'nim' => $nim,
            ]);

            // Membuat akun mahasiswa baru
            $akun = AkunMahasiswa::create([
                'kode_tim' => $kode_tim, // Foreign key ke tim
                'nim' => $nim,
                'password' => Hash::make($nim), // Set password dengan NIM yang di-hash
                'role' => 'mahasiswa',
            ]);

            Log::info('Akun berhasil dibuat:', $akun->toArray());

            // Setelah akun dibuat, simpan anggota tim ke tabel AnggotaTimPbl
            AnggotaTimPbl::create([
                'kode_tim' => $kode_tim,
                'nim' => $nim,
                'nama' => null, // Status bisa diset null jika tidak diisi
            ]);
        }

        // Mengirim respons JSON setelah registrasi berhasil
        return response()->json([
            'message' => 'Registrasi berhasil',
            'kode_tim' => $kode_tim,
            'anggota_nims' => $anggota_nims,
        ], 201);
    }
}
