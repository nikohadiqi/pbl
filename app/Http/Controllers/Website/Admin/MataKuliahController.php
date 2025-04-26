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
        $data = MataKuliah::all();
        return view('admin.mata-kuliah.matkul', compact('data'));
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
            'matakuliah' => 'required|string|max:255',
            'capaian' => 'required|string',
            'tujuan' => 'required|string',
        ]);

        MataKuliah::create([
            'matakuliah' => $request->matakuliah,
            'capaian' => $request->capaian,
            'tujuan' => $request->tujuan,
        ]);

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
        $request->validate([
            'matakuliah' => 'required|string|max:255',
            'capaian' => 'required|string',
            'tujuan' => 'required|string',
        ]);

        $matkul = MataKuliah::findOrFail($id);
        $matkul->update([
            'matakuliah' => $request->matakuliah,
            'capaian' => $request->capaian,
            'tujuan' => $request->tujuan,
        ]);

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
