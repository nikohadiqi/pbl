<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaController extends Controller
{
    // Menampilkan daftar mahasiswa
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        $kelas = Kelas::all();
        return view('admin.mahasiswa.mahasiswa', compact('mahasiswa', 'kelas'));
    }

    // Menampilkan form tambah mahasiswa
    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.mahasiswa.tambah-mahasiswa', compact('kelas'));
    }

    // Menyimpan data mahasiswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:15|unique:mahasiswa,nim',
            'nama' => 'required|string|max:100',
            'kelas' => 'required',
            'program_studi' => 'required',
            'status' => 'nullable',
            'dosen_wali' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'angkatan' => 'nullable',
        ]);

        Mahasiswa::create($request->all());

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data mahasiswa berhasil Ditambahkan!');

        return redirect()->route('admin.mahasiswa');
    }

    // Menampilkan form edit mahasiswa
    public function edit($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $kelas = Kelas::all();
        return view('admin.mahasiswa.edit-mahasiswa', compact('mahasiswa', 'kelas'));
    }

    // Memperbarui data mahasiswa
    public function update(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);

        $request->validate([
            'nim' => 'required|string|max:15|unique:mahasiswa,nim,' . $nim . ',nim',
            'nama' => 'required|string|max:100',
            'kelas' => 'required',
            'program_studi' => 'required',
            'status' => 'nullable',
            'dosen_wali' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'angkatan' => 'nullable',
        ]);

        $mahasiswa->update($request->all());

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data mahasiswa berhasil diperbarui!');

        return redirect()->route('admin.mahasiswa');
    }

    public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $mahasiswa->delete();

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data mahasiswa berhasil Dihapus!');

        return redirect()->route('admin.mahasiswa');
    }

}
