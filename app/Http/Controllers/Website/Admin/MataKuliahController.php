<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use RealRashid\SweetAlert\Facades\Alert;

class MataKuliahController extends Controller
{
    // **Tampilkan Semua Data Mata Kuliah**
    public function index()
    {
        $matkul = MataKuliah::all();
        return view('admin.mata-kuliah.matkul', compact('matkul'));
    }

    // **Tampilkan Form Tambah Mata Kuliah**
    public function create()
    {
        return view('admin.mata-kuliah.tambah-matkul');
    }

    // **Simpan Mata Kuliah Baru**
    public function store(Request $request)
    {
        $request->validate([
            'program_studi' => 'required|string',
            'kode' => 'required|string|unique:matakuliah,kode',
            'matakuliah' => 'required|string',
            'sks' => 'nullable|integer',
            'id_feeder' => 'nullable|string',
        ]);

        MataKuliah::create($request->all());

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Mata Kuliah berhasil Ditambahkan!');
        return redirect()->route('admin.matkul');
    }

    // **Tampilkan Form Edit**
    public function edit($id)
    {
        $matkul = MataKuliah::findOrFail($id);
        return view('admin.mata-kuliah.edit-matkul', compact('matkul'));
    }

    // **Update Mata Kuliah**
    public function update(Request $request, $id)
    {
        $matkul = MataKuliah::findOrFail($id);

        $request->validate([
            'program_studi' => 'required|string',
            'kode' => 'required|string|unique:matakuliah,kode,' . $id,
            'matakuliah' => 'required|string',
            'sks' => 'nullable|integer',
            'id_feeder' => 'nullable|string',
        ]);

        $matkul->update($request->all());

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Mata Kuliah berhasil Diperbarui!');
        return redirect()->route('admin.matkul');
    }

    // **Hapus Mata Kuliah**
    public function destroy($id)
    {
        $matkul = MataKuliah::findOrFail($id);
        $matkul->delete();

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Mata Kuliah berhasil Dihapus!');
        return redirect()->route('admin.matkul');
    }
}
