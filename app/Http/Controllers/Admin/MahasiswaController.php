<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'id_tahun' => 'required|string',
            'nim' => 'required|string|unique:mahasiswa,nim',
            'nama' => 'required|string',
        ]);

        $mahasiswa = Mahasiswa::create($request->all());

        return response()->json([
            'message' => 'Mahasiswa berhasil ditambahkan!',
            'data' => $mahasiswa
        ], 201);
    }

    public function get()
    {
        return response()->json(Mahasiswa::all());
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());

        return response()->json([
            'message' => 'Mahasiswa berhasil diperbarui!',
            'data' => $mahasiswa
        ]);
    }

    public function delete($id)
    {
        Mahasiswa::destroy($id);
        return response()->json(['message' => 'Mahasiswa berhasil dihapus!']);
    }

    public function bulkDelete(Request $request)
    {
        Mahasiswa::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Mahasiswa berhasil dihapus secara massal!']);
    }
}
