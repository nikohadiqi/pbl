<?php

namespace App\Http\Controllers\API\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logbook;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    // Menampilkan logbook berdasarkan tim
    public function index(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $logbooks = Logbook::where('kode_tim', $mahasiswa->kode_tim)->get();

        // Jika ada request 'selectedId', maka akan menampilkan logbook tertentu
        $selectedLogbook = null;
        if ($request->has('selectedId')) {
            $selectedLogbook = Logbook::find($request->input('selectedId'));
        }

        return response()->json([
            'logbooks' => $logbooks,
            'selectedLogbook' => $selectedLogbook
        ]);
    }

    // Menampilkan form untuk membuat logbook baru atau mengedit logbook yang sudah ada
    public function create(Request $request)
    {
        $minggu = $request->minggu;
        $logbook = Logbook::where('kode_tim', Auth::guard('mahasiswa')->user()->kode_tim)
                          ->where('minggu', $minggu)
                          ->first();
        return response()->json(['logbook' => $logbook]);
    }

    // Menampilkan logbook yang sudah ada berdasarkan ID
    public function show($id)
    {
        $logbook = Logbook::findOrFail($id);
        return response()->json(['logbook' => $logbook]);
    }

    // Menyimpan logbook baru atau mengupdate logbook yang sudah ada
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'aktivitas' => 'required|string|max:255',
            'hasil' => 'required|string|max:255',
            'progress' => 'required|integer|between:0,100',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'anggota1' => 'nullable|string|max:255',
            'anggota2' => 'nullable|string|max:255',
            'anggota3' => 'nullable|string|max:255',
            'anggota4' => 'nullable|string|max:255',
            'anggota5' => 'nullable|string|max:255',
            'minggu' => 'required|integer|between:1,16',  // Validasi minggu (1-16)
        ]);

        // Menyimpan foto kegiatan jika ada
        $filePath = null;
        if ($request->hasFile('foto_kegiatan')) {
            $file = $request->file('foto_kegiatan');
            $filePath = $file->store('foto_kegiatan', 'public');
        }

        // Cek apakah logbook untuk minggu yang sama sudah ada
        $logbook = Logbook::where('kode_tim', Auth::guard('mahasiswa')->user()->kode_tim)
                          ->where('minggu', $request->minggu)
                          ->first();

        if ($logbook) {
            // Update logbook jika sudah ada untuk minggu yang sama
            $logbook->update([
                'aktivitas' => $request->aktivitas,
                'hasil' => $request->hasil,
                'progress' => $request->progress,
                'anggota1' => $request->anggota1,
                'anggota2' => $request->anggota2,
                'anggota3' => $request->anggota3,
                'anggota4' => $request->anggota4,
                'anggota5' => $request->anggota5,
                'foto_kegiatan' => $filePath,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Logbook berhasil diperbarui!',
                'logbook' => $logbook
            ]);
        } else {
            // Buat logbook baru jika belum ada untuk minggu yang sama
            $logbook = Logbook::create([
                'kode_tim' => Auth::guard('mahasiswa')->user()->kode_tim,
                'aktivitas' => $request->aktivitas,
                'hasil' => $request->hasil,
                'progress' => $request->progress,
                'anggota1' => $request->anggota1,
                'anggota2' => $request->anggota2,
                'anggota3' => $request->anggota3,
                'anggota4' => $request->anggota4,
                'anggota5' => $request->anggota5,
                'foto_kegiatan' => $filePath,
                'minggu' => $request->minggu,  // Menyimpan minggu
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Logbook berhasil disimpan!',
                'logbook' => $logbook
            ]);
        }
    }

    // Mengupdate logbook yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'aktivitas' => 'required|string|max:255',
            'hasil' => 'required|string|max:255',
            'progress' => 'required|integer|between:0,100',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'anggota1' => 'nullable|string|max:255',
            'anggota2' => 'nullable|string|max:255',
            'anggota3' => 'nullable|string|max:255',
            'anggota4' => 'nullable|string|max:255',
            'anggota5' => 'nullable|string|max:255',
            'minggu' => 'nullable|string|max:50',
        ]);

        // Mengambil logbook yang ada
        $logbook = Logbook::findOrFail($id);

        // Mengupdate data logbook yang ada
        $logbook->update([
            'aktivitas' => $request->aktivitas,
            'hasil' => $request->hasil,
            'progress' => $request->progress,
            'anggota1' => $request->anggota1,
            'anggota2' => $request->anggota2,
            'anggota3' => $request->anggota3,
            'anggota4' => $request->anggota4,
            'anggota5' => $request->anggota5,
            'minggu' => $request->minggu,
        ]);

        // Menyimpan foto kegiatan jika ada
        if ($request->hasFile('foto_kegiatan')) {
            $file = $request->file('foto_kegiatan');
            $filePath = $file->store('foto_kegiatan', 'public');
            $logbook->update(['foto_kegiatan' => $filePath]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logbook berhasil diperbarui!',
            'logbook' => $logbook
        ]);
    }

    // Menghapus logbook yang ada
    public function destroy($id)
    {
        $logbook = Logbook::find($id);

        if (!$logbook) {
            return response()->json([
                'success' => false,
                'message' => 'Logbook tidak ditemukan'
            ], 404);
        }

        $logbook->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logbook berhasil dihapus'
        ]);
    }
}
