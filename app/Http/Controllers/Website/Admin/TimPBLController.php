<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\TimPBL;

class TimPBLController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'periode_pbl' => 'required|exists:periodepbl,id',
            'kelas' => 'required|string',
            'code_tim' => 'required|string|unique:timpbl,code_tim',
            'ketua_tim_nama' => 'required|string',
            'anggota_tim_nama' => 'required|array|min:1',
            'anggota_tim_nama.*' => 'string',
        ]);

        $ketuaTim = Mahasiswa::where('nama', $request->ketua_tim_nama)->first();
        if (!$ketuaTim) {
            return response()->json(['message' => 'Ketua Tim tidak ditemukan!'], 404);
        }

        $anggotaTim = Mahasiswa::whereIn('nama', $request->anggota_tim_nama)->get();
        if ($anggotaTim->count() !== count($request->anggota_tim_nama)) {
            return response()->json([
                'message' => 'Beberapa anggota tim tidak ditemukan!',
                'anggota_ditemukan' => $anggotaTim->pluck('nama')
            ], 404);
        }

        $timPBL = TimPBL::create([
            'periode_pbl' => $request->periode_pbl,
            'kelas' => $request->kelas,
            'code_tim' => $request->code_tim,
            'ketua_tim' => $ketuaTim->id,
            'anggota_tim' => json_encode($anggotaTim->pluck('id')->toArray()),
        ]);

        return response()->json([
            'message' => 'Tim PBL berhasil ditambahkan!',
            'data' => $timPBL
        ], 201);
    }

    public function get()
    {
        return response()->json(TimPBL::with(['periodePBL', 'ketuaTim'])->get());
    }

    public function update(Request $request, $id)
    {
        $timPBL = TimPBL::findOrFail($id);
        $timPBL->update($request->all());

        return response()->json([
            'message' => 'Tim PBL berhasil diperbarui!',
            'data' => $timPBL
        ]);
    }

    public function delete($id)
    {
        TimPBL::destroy($id);
        return response()->json(['message' => 'Tim PBL berhasil dihapus!']);
    }

    public function bulkDelete(Request $request)
    {
        TimPBL::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Tim PBL berhasil dihapus secara massal!']);
    }
}
