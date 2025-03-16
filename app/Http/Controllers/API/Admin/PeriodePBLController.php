<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodePBL;

class PeriodePBLController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'semester' => 'required|string|in:4,5',
            'tahun' => 'required|string',
        ]);

        $periode = PeriodePBL::create($request->all());

        return response()->json([
            'message' => 'Periode PBL berhasil ditambahkan!',
            'data' => $periode
        ], 201);
    }

    public function get()
    {
        return response()->json(PeriodePBL::all());
    }

    public function update(Request $request, $id)
    {
        $periode = PeriodePBL::findOrFail($id);
        $periode->update($request->all());

        return response()->json([
            'message' => 'Periode PBL berhasil diperbarui!',
            'data' => $periode
        ]);
    }

    public function delete($id)
    {
        PeriodePBL::destroy($id);
        return response()->json(['message' => 'Periode PBL berhasil dihapus!']);
    }

    public function bulkDelete(Request $request)
    {
        PeriodePBL::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Periode PBL berhasil dihapus secara massal!']);
    }
}
