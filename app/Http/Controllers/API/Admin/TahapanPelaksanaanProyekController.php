<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahapanPelaksanaanProyek;
use App\Models\PeriodePBL;

class TahapanPelaksanaanProyekController extends Controller
{
    // **Tampilkan Semua Data**
    public function index()
    {
        $data = TahapanPelaksanaanProyek::with('periodePBL')->get();
        return response()->json($data);
    }

    // **Tambah Data Baru**
    public function store(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:periodepbl,id',
            'tahapan' => 'required|string|max:255',
            'score' => 'required|integer',
        ]);

        $data = TahapanPelaksanaanProyek::create($request->all());

        return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $data], 201);
    }

    // **Tampilkan Data Berdasarkan ID**
    public function show($id)
    {
        $data = TahapanPelaksanaanProyek::with('periodePBL')->find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data);
    }

    // **Update Data Berdasarkan ID**
    public function update(Request $request, $id)
    {
        $data = TahapanPelaksanaanProyek::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'semester_id' => 'exists:periodepbl,id',
            'tahapan' => 'string|max:255',
            'score' => 'integer',
        ]);

        $data->update($request->all());

        return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $data]);
    }

    // **Hapus Data Berdasarkan ID**
    public function destroy($id)
    {
        $data = TahapanPelaksanaanProyek::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    // **Bulk Delete (Hapus Banyak Data)**
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:tahapan_pelaksanaan_proyek,id',
        ]);

        TahapanPelaksanaanProyek::whereIn('id', $request->ids)->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
