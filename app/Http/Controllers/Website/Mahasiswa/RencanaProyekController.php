<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RencanaProyek;
use App\Models\TimPBL; // Pastikan model TimPBL diimpor

class RencanaProyekController extends Controller
{
    /**
     * Tampilkan semua rencana proyek yang hanya milik tim mahasiswa yang login.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // Cari tim di mana mahasiswa yang login adalah ketua atau anggota.
        $team = TimPBL::whereJsonContains('anggota_tim', $userId)
            ->orWhere('ketua_tim', $userId)
            ->first();

        if (!$team) {
            return response()->json(['message' => 'Tim PBL tidak ditemukan untuk mahasiswa ini'], 404);
        }

        // Ambil semua rencana proyek yang terkait dengan tim tersebut.
        $data = RencanaProyek::where('timpbl_id', $team->id)->get();
        return response()->json($data);
    }

    /**
     * Tambah data rencana proyek baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'timpbl_id'        => 'required|exists:timpbl,id',
            'judul_proyek'     => 'nullable|string|max:255',
            'pengusul_proyek'  => 'nullable|string|max:255',
            'manajer_proyek'   => 'nullable|string|max:255',
            'luaran'           => 'nullable|string',
            'sponsor'          => 'nullable|string',
            'biaya'            => 'nullable|numeric',
            'klien'            => 'nullable|string|max:255',
            'waktu'            => 'nullable|string|max:255',
            'ruang_lingkup'    => 'nullable|string',
            'rancangan_sistem' => 'nullable|string',
        ]);

        // Pastikan bahwa rencana proyek yang ditambahkan adalah milik tim mahasiswa yang login
        $validated['mahasiswa_id'] = $request->user()->id;

        $data = RencanaProyek::create($validated);

        return response()->json([
            'message' => 'Rencana Proyek berhasil ditambahkan',
            'data'    => $data
        ], 201);
    }

    /**
     * Tampilkan detail rencana proyek berdasarkan ID (hanya jika dimiliki oleh tim mahasiswa yang login).
     */
    public function show(Request $request, $id)
    {
        $data = RencanaProyek::where('id', $id)
                              ->where('mahasiswa_id', $request->user()->id)
                              ->first();
        if (!$data) {
            return response()->json(['message' => 'Rencana Proyek tidak ditemukan'], 404);
        }
        return response()->json($data);
    }

    /**
     * Update data rencana proyek berdasarkan ID (hanya jika dimiliki oleh mahasiswa yang login).
     */
    public function update(Request $request, $id)
    {
        $data = RencanaProyek::where('id', $id)
                              ->where('mahasiswa_id', $request->user()->id)
                              ->first();
        if (!$data) {
            return response()->json(['message' => 'Rencana Proyek tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'timpbl_id'        => 'sometimes|exists:timpbl,id',
            'judul_proyek'     => 'nullable|string|max:255',
            'pengusul_proyek'  => 'nullable|string|max:255',
            'manajer_proyek'   => 'nullable|string|max:255',
            'luaran'           => 'nullable|string',
            'sponsor'          => 'nullable|string',
            'biaya'            => 'nullable|numeric',
            'klien'            => 'nullable|string|max:255',
            'waktu'            => 'nullable|string|max:255',
            'ruang_lingkup'    => 'nullable|string',
            'rancangan_sistem' => 'nullable|string',
        ]);

        $data->update($validated);

        return response()->json([
            'message' => 'Rencana Proyek berhasil diperbarui',
            'data'    => $data
        ]);
    }

    /**
     * Hapus data rencana proyek berdasarkan ID (hanya jika dimiliki oleh mahasiswa yang login).
     */
    public function destroy(Request $request, $id)
    {
        $data = RencanaProyek::where('id', $id)
                              ->where('mahasiswa_id', $request->user()->id)
                              ->first();
        if (!$data) {
            return response()->json(['message' => 'Rencana Proyek tidak ditemukan'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'Rencana Proyek berhasil dihapus']);
    }

    /**
     * Bulk Delete: Hapus banyak rencana proyek (hanya data yang dimiliki oleh mahasiswa yang login).
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:rencana_proyek,id'
        ]);

        RencanaProyek::whereIn('id', $validated['ids'])
                     ->where('mahasiswa_id', $request->user()->id)
                     ->delete();
        return response()->json(['message' => 'Rencana Proyek berhasil dihapus secara massal']);
    }
}
