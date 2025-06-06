<?php

namespace App\Http\Controllers\API\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CapaianPembelajaran;
use App\Models\TimPBL;

class CapaianPembelajaranController extends Controller
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

    // Tampilkan semua data capaian pembelajaran untuk tim mahasiswa yang login
    public function index(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = CapaianPembelajaran::where('timpbl_id', $team->id)->get();
        return response()->json($data);
    }

    // Tambah data capaian pembelajaran baru
    public function store(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'mata_kuliah' => 'required|string|max:255',
            'capaian'     => 'required|string',
            'tujuan'      => 'required|string',
        ]);

        $validated['timpbl_id'] = $team->id;
        $validated['mahasiswa_id'] = $request->user()->id;

        $data = CapaianPembelajaran::create($validated);

        return response()->json([
            'message' => 'Capaian pembelajaran berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    // Tampilkan detail capaian pembelajaran berdasarkan ID
    public function show(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = CapaianPembelajaran::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data);
    }

    // Update data capaian pembelajaran berdasarkan ID
    public function update(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = CapaianPembelajaran::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'mata_kuliah' => 'sometimes|string|max:255',
            'capaian'     => 'sometimes|string',
            'tujuan'      => 'sometimes|string',
        ]);

        $data->update($validated);
        return response()->json([
            'message' => 'Capaian pembelajaran berhasil diperbarui',
            'data'    => $data
        ]);
    }

    // Hapus data capaian pembelajaran berdasarkan ID
    public function destroy(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = CapaianPembelajaran::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Capaian pembelajaran berhasil dihapus']);
    }

    // Bulk Delete: Hapus banyak data capaian pembelajaran
    public function bulkDelete(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:capaian_pembelajaran,id'
        ]);

        CapaianPembelajaran::whereIn('id', $validated['ids'])
            ->where('timpbl_id', $team->id)
            ->delete();

        return response()->json(['message' => 'Capaian pembelajaran berhasil dihapus secara massal']);
    }
}
