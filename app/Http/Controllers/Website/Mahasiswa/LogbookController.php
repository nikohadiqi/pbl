<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AkunMahasiswa;
use App\Models\regMahasiswa;
use App\Models\Anggota_Tim_Pbl;
use App\Models\Logbook;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $logbooks = Logbook::where('kode_tim', $mahasiswa->kode_tim)->get();

        $selectedLogbook = null;
        if ($request->has('selectedId')) {
            $selectedLogbook = Logbook::find($request->input('selectedId'));
        }

        return view('mahasiswa.semester4.logbook.logbook', compact('logbooks', 'selectedLogbook'));
    }

        public function create()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $logbook = Logbook::where('kode_tim', $mahasiswa->kode_tim)->first();

        return view('mahasiswa.semester4.logbook.form-logbook', compact('logbook'));
    }

    public function store(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

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
        ]);

        $logbook = Logbook::where('kode_tim', $mahasiswa->kode_tim)->first();

        $filePath = null;
        if ($request->hasFile('foto_kegiatan')) {
            $file = $request->file('foto_kegiatan');
            $filePath = $file->store('foto_kegiatan', 'public');
        }

        if ($logbook) {
            $logbook->update([
                'aktivitas' => $request->aktivitas,
                'hasil' => $request->hasil,
                'progress' => $request->progress,
                'anggota1' => $request->anggota1,
                'anggota2' => $request->anggota2,
                'anggota3' => $request->anggota3,
                'anggota4' => $request->anggota4,
                'anggota5' => $request->anggota5,
            ]);

            if ($filePath) {
                $logbook->update(['foto_kegiatan' => $filePath]);
            }
        } else {
            $logbook = Logbook::create([
                'kode_tim' => $mahasiswa->kode_tim,
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
        }

        return redirect()->route('mahasiswa.logbook.store', ['id' => $logbook->id])
            ->with('success', 'Logbook berhasil disimpan!');
    }

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
