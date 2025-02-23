<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;

class MataKuliahController extends Controller
{
    // Tampilkan semua data Mata Kuliah dengan relasi dosen
    public function index()
    {
        $data = MataKuliah::with('dosen')->get();
        return response()->json($data);
    }

    // Tambah data Mata Kuliah baru
    public function store(Request $request)
    {
        $request->validate([
            'matakuliah' => 'required|string|max:255',
            'capaian'    => 'required|string',
            'tujuan'     => 'required|string',
            'dosen_id'   => 'required|exists:dosen,id', // Validasi dosen_id
        ]);

        $data = MataKuliah::create($request->all());

        return response()->json([
            'message' => 'Mata Kuliah berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    // Tampilkan data Mata Kuliah berdasarkan ID
    public function show($id)
    {
        $data = MataKuliah::with('dosen')->find($id);
        if (!$data) {
            return response()->json(['message' => 'Mata Kuliah tidak ditemukan'], 404);
        }
        return response()->json($data);
    }

    // Update data Mata Kuliah berdasarkan ID
    public function update(Request $request, $id)
    {
        $data = MataKuliah::find($id);
        if (!$data) {
            return response()->json(['message' => 'Mata Kuliah tidak ditemukan'], 404);
        }

        $request->validate([
            'matakuliah' => 'string|max:255',
            'capaian'    => 'string',
            'tujuan'     => 'string',
            'dosen_id'   => 'exists:dosen,id', // Pastikan dosen_id valid jika diupdate
        ]);

        $data->update($request->all());

        return response()->json([
            'message' => 'Mata Kuliah berhasil diperbarui',
            'data'    => $data
        ]);
    }

    // Hapus data Mata Kuliah berdasarkan ID
    public function destroy($id)
    {
        $data = MataKuliah::find($id);
        if (!$data) {
            return response()->json(['message' => 'Mata Kuliah tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Mata Kuliah berhasil dihapus']);
    }

    // Bulk delete (hapus banyak data)
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:mata_kuliah,id',
        ]);

        MataKuliah::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Data berhasil dihapus secara massal']);
    }
}
