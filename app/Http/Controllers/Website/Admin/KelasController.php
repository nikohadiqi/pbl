<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KelasController extends Controller
{
    // Menampilkan daftar kelas
    public function index()
    {
        $kelas = Kelas::all();
        // Ubah setiap nama kelas menjadi base64 aman untuk digunakan di HTML ID
        foreach ($kelas as $item) {
            $item->kelas_encoded = base64_encode($item->kelas);
        }
        return view('admin.kelas.kelas', compact('kelas'));
    }

    // Menampilkan form tambah kelas
    public function create()
    {
        return view('admin.kelas.tambah-kelas');
    }

    // Menyimpan data kelas baru
    public function store(Request $request)
    {
        $request->validate([
            'kelas' => [
                'required',
                'regex:/^[0-9]{1}[A-Za-z]{1}$/',
                'unique:kelas,kelas' . ($kelas->kelas ?? ''),
            ],
        ], [
            'kelas.regex' => 'Format kelas harus 1 angka diikuti 1 huruf, misalnya 2A.',
            'kelas.unique' => 'Kelas ini sudah terdaftar.',
        ]);

        Kelas::create($request->all());

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data kelas berhasil Ditambahkan!');

        return redirect()->route('admin.kelas');
    }

    // Menampilkan form edit kelas
    public function edit($kelas)
    {
        $kelas = Kelas::findOrFail($kelas);
        return view('admin.kelas.edit-kelas', compact('kelas'));
    }

    // Memperbarui data kelas
    public function update(Request $request, $kelas)
    {
        $kelas = Kelas::findOrFail($kelas);

        $request->validate([
            'kelas' => [
                'required',
                'regex:/^[0-9]{1}[A-Za-z]{1}$/',
                'unique:kelas,kelas,' . $kelas->kelas . ',kelas',
            ],
        ], [
            'kelas.regex' => 'Format kelas harus 1 angka diikuti 1 huruf, misalnya 2A.',
            'kelas.unique' => 'Kelas ini sudah terdaftar.',
        ]);

        $kelas->update($request->all());

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data kelas berhasil diperbarui!');

        return redirect()->route('admin.kelas');
    }

    public function destroy($kelas)
    {
        $kelas = Kelas::findOrFail($kelas);
        $kelas->delete();

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data kelas berhasil Dihapus!');

        return redirect()->route('admin.kelas');
    }
}
