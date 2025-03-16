<?php

namespace App\Http\Controllers\API\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimProyek;
use App\Models\TimPBL;

class TimProyekController extends Controller
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

    // Tampilkan semua anggota tim proyek dari tim mahasiswa yang login
    public function index(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = TimProyek::where('timpbl_id', $team->id)->get();
        return response()->json($data);
    }

    // Tambah anggota baru ke tim proyek
    public function store(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nim'           => 'required|string|max:20|unique:tim_proyek,nim',
            'program_studi' => 'required|string|max:255',
        ]);

        $validated['timpbl_id'] = $team->id;
        $validated['mahasiswa_id'] = $request->user()->id;

        $data = TimProyek::create($validated);

        return response()->json([
            'message' => 'Anggota tim proyek berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    // Tampilkan detail anggota tim proyek berdasarkan ID
    public function show(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = TimProyek::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data);
    }

    // Update data anggota tim proyek berdasarkan ID
    public function update(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = TimProyek::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'nama'          => 'sometimes|string|max:255',
            'nim'           => 'sometimes|string|max:20|unique:tim_proyek,nim,' . $id,
            'program_studi' => 'sometimes|string|max:255',
        ]);

        $data->update($validated);
        return response()->json([
            'message' => 'Data anggota tim proyek berhasil diperbarui',
            'data'    => $data
        ]);
    }

    // Hapus anggota tim proyek berdasarkan ID
    public function destroy(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = TimProyek::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Anggota tim proyek berhasil dihapus']);
    }

    // Bulk Delete: Hapus banyak anggota tim proyek sekaligus
    public function bulkDelete(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:tim_proyek,id'
        ]);

        TimProyek::whereIn('id', $validated['ids'])
            ->where('timpbl_id', $team->id)
            ->delete();

        return response()->json(['message' => 'Anggota tim proyek berhasil dihapus secara massal']);
    }
}
