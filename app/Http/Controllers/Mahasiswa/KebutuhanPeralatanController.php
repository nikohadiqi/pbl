<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KebutuhanPeralatan;
use App\Models\TimPBL;

class KebutuhanPeralatanController extends Controller
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

    // Tampilkan semua data kebutuhan peralatan untuk tim mahasiswa yang login
    public function index(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = KebutuhanPeralatan::where('timpbl_id', $team->id)->get();
        return response()->json($data);
    }

    // Tambah data kebutuhan peralatan baru
    public function store(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'proses'    => 'required|string|max:255',
            'peralatan' => 'required|string',
            'bahan'     => 'required|string',
        ]);

        // Pastikan mahasiswa hanya menambahkan data untuk timnya
        $validated['timpbl_id'] = $team->id;
        $validated['mahasiswa_id'] = $request->user()->id;

        $data = KebutuhanPeralatan::create($validated);

        return response()->json([
            'message' => 'Kebutuhan peralatan berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    // Tampilkan detail kebutuhan peralatan berdasarkan ID
    public function show(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = KebutuhanPeralatan::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data);
    }

    // Update data kebutuhan peralatan berdasarkan ID
    public function update(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = KebutuhanPeralatan::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'proses'    => 'sometimes|string|max:255',
            'peralatan' => 'sometimes|string',
            'bahan'     => 'sometimes|string',
        ]);

        $data->update($validated);
        return response()->json([
            'message' => 'Kebutuhan peralatan berhasil diperbarui',
            'data'    => $data
        ]);
    }

    // Hapus data kebutuhan peralatan berdasarkan ID
    public function destroy(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = KebutuhanPeralatan::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Kebutuhan peralatan berhasil dihapus']);
    }

    // Bulk Delete: Hapus banyak data kebutuhan peralatan
    public function bulkDelete(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:kebutuhan_peralatan,id'
        ]);

        // Hapus hanya data yang milik tim mahasiswa yang login
        KebutuhanPeralatan::whereIn('id', $validated['ids'])
            ->where('timpbl_id', $team->id)
            ->delete();

        return response()->json(['message' => 'Kebutuhan peralatan berhasil dihapus secara massal']);
    }
}
