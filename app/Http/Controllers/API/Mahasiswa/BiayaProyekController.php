<?php

namespace App\Http\Controllers\API\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BiayaProyek;
use App\Models\TimPBL;

class BiayaProyekController extends Controller
{
    /**
     * Ambil tim PBL yang terkait dengan mahasiswa yang login.
     */
    private function getUserTeam(Request $request)
    {
        $userId = $request->user()->id;

        $team = TimPBL::whereJsonContains('anggota_tim', $userId)
            ->orWhere('ketua_tim', $userId)
            ->first();

        return $team;
    }

    // Tampilkan semua data biaya proyek untuk tim mahasiswa yang login
    public function index(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = BiayaProyek::where('timpbl_id', $team->id)->get();
        return response()->json($data);
    }

    // Tambah data biaya proyek baru
    public function store(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'proses'            => 'required|string|max:255',
            'uraian_pekerjaan'  => 'required|string',
            'perkiraan_biaya'   => 'required|numeric|min:0',
            'catatan'           => 'nullable|string',
        ]);

        // Pastikan mahasiswa hanya menambahkan data untuk timnya
        $validated['timpbl_id'] = $team->id;
        $validated['mahasiswa_id'] = $request->user()->id;

        $data = BiayaProyek::create($validated);

        return response()->json([
            'message' => 'Biaya proyek berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    // Tampilkan detail biaya proyek berdasarkan ID
    public function show(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = BiayaProyek::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data);
    }

    // Update data biaya proyek berdasarkan ID
    public function update(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = BiayaProyek::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'proses'            => 'sometimes|string|max:255',
            'uraian_pekerjaan'  => 'sometimes|string',
            'perkiraan_biaya'   => 'sometimes|numeric|min:0',
            'catatan'           => 'sometimes|string',
        ]);

        $data->update($validated);
        return response()->json([
            'message' => 'Biaya proyek berhasil diperbarui',
            'data'    => $data
        ]);
    }

    // Hapus data biaya proyek berdasarkan ID
    public function destroy(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = BiayaProyek::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Biaya proyek berhasil dihapus']);
    }

    // Bulk Delete: Hapus banyak data biaya proyek
    public function bulkDelete(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:biaya_proyek,id'
        ]);

        // Hapus hanya data yang milik tim mahasiswa yang login
        BiayaProyek::whereIn('id', $validated['ids'])
            ->where('timpbl_id', $team->id)
            ->delete();

        return response()->json(['message' => 'Biaya proyek berhasil dihapus secara massal']);
    }
}
