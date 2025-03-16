<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tantangan;
use App\Models\TimPBL;

class TantanganController extends Controller
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

    // Tampilkan semua tantangan dalam tim mahasiswa yang login
    public function index(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = Tantangan::where('timpbl_id', $team->id)->get();
        return response()->json($data);
    }

    // Tambah tantangan baru
    public function store(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'proses'           => 'required|string|max:255',
            'tantangan'        => 'required|string',
            'level'            => 'required|integer|min:1|max:5',
            'rencana_tindakan' => 'required|string',
            'catatan'          => 'nullable|string',
        ]);

        $validated['timpbl_id'] = $team->id;
        $validated['mahasiswa_id'] = $request->user()->id;

        $data = Tantangan::create($validated);

        return response()->json([
            'message' => 'Tantangan berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    // Tampilkan detail tantangan berdasarkan ID
    public function show(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = Tantangan::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data);
    }

    // Update tantangan berdasarkan ID
    public function update(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = Tantangan::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'proses'           => 'sometimes|string|max:255',
            'tantangan'        => 'sometimes|string',
            'level'            => 'sometimes|integer|min:1|max:5',
            'rencana_tindakan' => 'sometimes|string',
            'catatan'          => 'nullable|string',
        ]);

        $data->update($validated);
        return response()->json([
            'message' => 'Tantangan berhasil diperbarui',
            'data'    => $data
        ]);
    }

    // Hapus tantangan berdasarkan ID
    public function destroy(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = Tantangan::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Tantangan berhasil dihapus']);
    }

    // Bulk Delete: Hapus banyak tantangan sekaligus
    public function bulkDelete(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:tantangan,id'
        ]);

        Tantangan::whereIn('id', $validated['ids'])
            ->where('timpbl_id', $team->id)
            ->delete();

        return response()->json(['message' => 'Tantangan berhasil dihapus secara massal']);
    }
}
