<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AkunMahasiswa;
use App\Models\Anggota_Tim_Pbl;
use App\Models\Kelas;
use App\Models\PeriodePBL;
use App\Models\regMahasiswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaRegisterController extends Controller
{
    public function showRegisterForm()
    {
        $kelas = Kelas::all();
        $periode = PeriodePBL::select('id', 'semester', 'tahun')->get();

        return view('auth.register', compact('kelas', 'periode'));
    }

    public function register(Request $request)
    {
        // Validasi inputan agar sesuai
        $request->validate([
            'kelas' => 'required|string',
            'kelompok' => 'required|integer',
            'manpro' => 'required|string|exists:pengampu,dosen_id',
            'periode' => 'required|string',
            'anggota' => 'required|array|min:1',
            'anggota.*' => 'string|distinct|exists:data_mahasiswa,nim|unique:anggota_tim_pbl,nim',
        ], [
            'anggota.*.unique' => 'Mahasiswa dengan NIM :input sudah terdaftar di tim lain.',
            'anggota.*.exists' => 'Mahasiswa dengan NIM :input tidak ditemukan.',
            'anggota.*.distinct' => 'Mahasiswa dengan NIM :input duplikat di daftar anggota.',
        ]);

        $kode_tim = strtoupper($request->kelas) . $request->kelompok;

        Log::info('Membuat kode tim baru', ['kode_tim' => $kode_tim]);

        // Buat data tim
        $tim = regMahasiswa::firstOrCreate([
            'kode_tim' => $kode_tim,
        ], [
            'kelas' => $request->kelas,
            'kelompok' => $request->kelompok,
            'manpro' => $request->manpro,
            'periode' => $request->periode,
        ]);

        foreach ($request->anggota as $nim) {
            Log::info('Membuat akun dan anggota tim untuk NIM', ['nim' => $nim]);

            AkunMahasiswa::create([
                'kode_tim' => $kode_tim,
                'nim' => $nim,
                'password' => Hash::make($nim),
                'role' => 'mahasiswa',
            ]);

            Anggota_Tim_Pbl::create([
                'kode_tim' => $kode_tim,
                'nim' => $nim,
                'manpro' => $request->manpro,
                'periode' => $request->periode,
                'status' => null, // Atau default status tertentu
            ]);
        }

        Alert::success('Registrasi Berhasil', 'Akun mahasiswa dan tim berhasil dibuat!');
        return redirect()->route('login');
    }
}
