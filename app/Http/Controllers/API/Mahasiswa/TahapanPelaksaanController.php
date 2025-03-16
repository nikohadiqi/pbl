<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahapanPelaksaan;
use App\Models\TimPBL;

class TahapanPelaksaanController extends Controller
{
    /**
     * Ambil tim PBL yang terkait dengan mahasiswa yang login.
     * Asumsi: mahasiswa adalah anggota atau ketua di salah satu TimPBL.
     */
    private function getUserTeam(Request $request)
    {
        // Cari tim di mana mahasiswa_id (login) ada di anggota_tim JSON atau sebagai ketua_tim.
        // Sesuaikan logika ini jika struktur tim Anda berbeda.
        $userId = $request->user()->id;

        $team = TimPBL::whereJsonContains('anggota_tim', $userId)
            ->orWhere('ketua_tim', $userId)
            ->first();

        return $team;
    }

    // Tampilkan semua tahapan pelaksaan untuk tim mahasiswa yang login
    public function index(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = TahapanPelaksaan::where('timpbl_id', $team->id)->get();
        return response()->json($data);
    }

    // Tambah data tahapan pelaksaan baru
    public function store(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'minggu'     => 'required|integer',
            'tahapan'    => 'required|string|max:255',
            'pic'        => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        // Pastikan mahasiswa hanya menambahkan data untuk timnya
        $validated['timpbl_id'] = $team->id;

        $data = TahapanPelaksaan::create($validated);

        return response()->json([
            'message' => 'Tahapan pelaksaan berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    // Tampilkan detail tahapan pelaksaan berdasarkan ID (hanya jika data milik tim mahasiswa yang login)
    public function show(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = TahapanPelaksaan::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data);
    }

    // Update data tahapan pelaksaan berdasarkan ID
    public function update(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = TahapanPelaksaan::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'minggu'     => 'sometimes|integer',
            'tahapan'    => 'sometimes|string|max:255',
            'pic'        => 'sometimes|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $data->update($validated);
        return response()->json([
            'message' => 'Tahapan pelaksaan berhasil diperbarui',
            'data'    => $data
        ]);
    }

    // Hapus data tahapan pelaksaan berdasarkan ID
    public function destroy(Request $request, $id)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $data = TahapanPelaksaan::where('id', $id)
                    ->where('timpbl_id', $team->id)
                    ->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Tahapan pelaksaan berhasil dihapus']);
    }

    // Bulk Delete: Hapus banyak data tahapan pelaksaan
    public function bulkDelete(Request $request)
    {
        $team = $this->getUserTeam($request);
        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:tahapan_pelaksaan,id'
        ]);

        // Hapus hanya data yang milik tim mahasiswa yang login
        TahapanPelaksaan::whereIn('id', $validated['ids'])
            ->where('timpbl_id', $team->id)
            ->delete();

        return response()->json(['message' => 'Tahapan pelaksaan berhasil dihapus secara massal']);
    }
}
