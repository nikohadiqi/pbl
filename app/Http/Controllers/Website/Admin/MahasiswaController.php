<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaController extends Controller
{
    // Menampilkan daftar mahasiswa
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('admin.akun-mahasiswa.mahasiswa', compact('mahasiswa'));
    }

    // Menampilkan form tambah mahasiswa
    public function create()
    {
        return view('admin.akun-mahasiswa.tambah-mahasiswa');
    }

    // Menyimpan data mahasiswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:15|unique:mahasiswa,nim',
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:10',
        ]);

        Mahasiswa::create($request->all());

        // Menampilkan SweetAlert

        Alert::success('Berhasil!', 'Data Berhasil Ditambahkan!');
        

        Alert::success('Berhasil!', 'Data mahasiswa berhasil Ditambahkan!');


        return redirect()->route('admin.mahasiswa');
    }

    // Menampilkan form edit mahasiswa
    public function edit($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        return view('admin.akun-mahasiswa.edit-mahasiswa', compact('mahasiswa'));
    }

    // Memperbarui data mahasiswa
    public function update(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);

        $request->validate([
            'nim' => 'required|string|max:15|unique:mahasiswa,nim,' . $nim . ',nim',
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:10',
        ]);        

        $mahasiswa->update($request->all());

        // Menampilkan SweetAlert

        Alert::success('Berhasil!', 'Data Berhasil Diba!');

        Alert::success('Berhasil!', 'Data mahasiswa berhasil diperbarui!');


        return redirect()->route('admin.mahasiswa');
    }

    public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $mahasiswa->delete();

        
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Berhasil Diaps!');


        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data mahasiswa berhasil Dihapus!');


        return redirect()->route('admin.mahasiswa');
    }

}
