<?php

namespace App\Http\Controllers\API\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EstimasiWaktu;
use App\Models\TimPBL;

class EstimasiWaktuController extends Controller
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

    // Tampilkan semua data estimasi waktu untuk tim mahasiswa yang login
    public function index(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = EstimasiWaktu::where('timpbl_id', $team->id)->get();
        return response()->json($data);
    }

    // Tambah data estimasi waktu baru
    public function store(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'proses'            => 'required|string|max:255',
            'uraian_pekerjaan'  => 'required|string',
            'estimasi'          => 'required|integer|min:1',
            'catatan'           => 'nullable|string',
        ]);

        $validated['timpbl_id'] = $team->id;
        $validated['mahasiswa_id'] = $request->user()->id;

        $data = EstimasiWaktu::create($validated);

        return response()->json([
            'message' => 'Estimasi waktu berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    // Tampilkan detail estimasi waktu berdasarkan ID
    public function show(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = EstimasiWaktu::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data);
    }

    // Update data estimasi waktu berdasarkan ID
    public function update(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = EstimasiWaktu::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'proses'            => 'sometimes|string|max:255',
            'uraian_pekerjaan'  => 'sometimes|string',
            'estimasi'          => 'sometimes|integer|min:1',
            'catatan'           => 'sometimes|string',
        ]);

        $data->update($validated);
        return response()->json([
            'message' => 'Estimasi waktu berhasil diperbarui',
            'data'    => $data
        ]);
    }

    // Hapus data estimasi waktu berdasarkan ID
    public function destroy(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = EstimasiWaktu::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Estimasi waktu berhasil dihapus']);
    }

    // Bulk Delete: Hapus banyak data estimasi waktu
    public function bulkDelete(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:estimasi_waktu,id'
        ]);

        EstimasiWaktu::whereIn('id', $validated['ids'])
            ->where('timpbl_id', $team->id)
            ->delete();

        return response()->json(['message' => 'Estimasi waktu berhasil dihapus secara massal']);
    }
}
