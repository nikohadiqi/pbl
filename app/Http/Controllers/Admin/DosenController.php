<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;

class DosenController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|unique:dosen,nip',
            'nama' => 'required|string',
        ]);

        $dosen = Dosen::create($request->all());

        return response()->json([
            'message' => 'Dosen berhasil ditambahkan!',
            'data' => $dosen
        ], 201);
    }

    public function get()
    {
        return response()->json(Dosen::all());
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->update($request->all());

        return response()->json([
            'message' => 'Dosen berhasil diperbarui!',
            'data' => $dosen
        ]);
    }

    public function delete($id)
    {
        Dosen::destroy($id);
        return response()->json(['message' => 'Dosen berhasil dihapus!']);
    }

    public function bulkDelete(Request $request)
    {
        Dosen::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Dosen berhasil dihapus secara massal!']);
    }
}
