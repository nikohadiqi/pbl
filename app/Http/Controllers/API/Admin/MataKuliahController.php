<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;

class MataKuliahController extends Controller
{
    // **Tampilkan Semua Data**
    public function index()
    {
        $data = MataKuliah::all();
        return response()->json($data);
    }

    // **Tambah Data Baru**
    public function store(Request $request)
    {
        $request->validate([
            'matakuliah' => 'required|string|max:255',
            'capaian' => 'required|string',
            'tujuan' => 'required|string',
        ]);

        $data = MataKuliah::create($request->all());

        return response()->json(['message' => 'Mata Kuliah berhasil ditambahkan', 'data' => $data], 201);
    }

    // **Tampilkan Data Berdasarkan ID**
    public function show($id)
    {
        $data = MataKuliah::find($id);
        if (!$data) {
            return response()->json(['message' => 'Mata Kuliah tidak ditemukan'], 404);
        }
        return response()->json($data);
    }

    // **Update Data Berdasarkan ID**
    public function update(Request $request, $id)
    {
        $data = MataKuliah::find($id);
        if (!$data) {
            return response()->json(['message' => 'Mata Kuliah tidak ditemukan'], 404);
        }

        $request->validate([
            'matakuliah' => 'string|max:255',
            'capaian' => 'string',
            'tujuan' => 'string',
        ]);

        $data->update($request->all());

        return response()->json(['message' => 'Mata Kuliah berhasil diperbarui', 'data' => $data]);
    }

    // **Hapus Data Berdasarkan ID**
    public function destroy($id)
    {
        $data = MataKuliah::find($id);
        if (!$data) {
            return response()->json(['message' => 'Mata Kuliah tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Mata Kuliah berhasil dihapus']);
    }

    // **Bulk Delete (Hapus Banyak Data)**
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:mata_kuliah,id',
        ]);

        MataKuliah::whereIn('id', $request->ids)->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
