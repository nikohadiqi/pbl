<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    /**
     * Ambil semua data dosen
     */
    public function index()
    {
        $dosens = Dosen::all();
        return response()->json(['success' => true, 'message' => 'List of Dosen', 'data' => $dosens], 200);
    }

    /**
     * Tambah dosen baru
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|unique:dosen,nip',
            'nama' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 400);
        }

        $dosen = Dosen::create($request->all());

        return response()->json(['success' => true, 'message' => 'Dosen berhasil ditambahkan!', 'data' => $dosen], 201);
    }

    /**
     * Ambil detail dosen
     */
    public function show($id)
    {
        $dosen = Dosen::find($id);
        if (!$dosen) {
            return response()->json(['success' => false, 'message' => 'Dosen tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $dosen], 200);
    }

    /**
     * Update data dosen
     */
    public function update(Request $request, $id)
    {
        $dosen = Dosen::find($id);
        if (!$dosen) {
            return response()->json(['success' => false, 'message' => 'Dosen tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nip' => 'sometimes|string|unique:dosen,nip,' . $id,
            'nama' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 400);
        }

        $dosen->update($request->all());
        return response()->json(['success' => true, 'message' => 'Dosen berhasil diperbarui!', 'data' => $dosen], 200);
    }

    /**
     * Hapus dosen
     */
    public function delete($id)
    {
        $dosen = Dosen::find($id);
        if (!$dosen) {
            return response()->json(['success' => false, 'message' => 'Dosen tidak ditemukan'], 404);
        }
        $dosen->delete();
        return response()->json(['success' => true, 'message' => 'Dosen berhasil dihapus!'], 200);
    }

    /**
     * Bulk delete dosen
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        Dosen::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'Dosen berhasil dihapus secara massal!'], 200);
    }
}
