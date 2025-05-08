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

    public function show($id)
    {
        $logbook = Logbook::findOrFail($id);
        return view('mahasiswa.semester4.logbook.show.logbook', compact('logbook'));
    }
    
    public function create()
    {
        $logbook = null;
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
    
        $logbook = new Logbook();
        $logbook->kode_tim = $mahasiswa->kode_tim;
        $logbook->aktivitas = $request->aktivitas;
        $logbook->hasil = $request->hasil;
        $logbook->progress = $request->progress;
        $logbook->anggota1 = $request->anggota1;
        $logbook->anggota2 = $request->anggota2;
        $logbook->anggota3 = $request->anggota3;
        $logbook->anggota4 = $request->anggota4;
        $logbook->anggota5 = $request->anggota5;
    
        if ($request->hasFile('foto_kegiatan')) {
            $logbook->foto_kegiatan = $request->file('foto_kegiatan')->store('foto_kegiatan', 'public');
        }
    
        $logbook->save();
    
        return redirect()->route('mahasiswa.logbook')->with('success', 'Logbook berhasil disimpan!');
    }
    
    public function edit($id)
    {
        $logbook = Logbook::findOrFail($id);
        return view('mahasiswa.semester4.logbook.form-logbook', compact('logbook'));
    }

    public function update(Request $request, $id)
    {
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

        $logbook = Logbook::findOrFail($id);
        $logbook->aktivitas = $request->aktivitas;
        $logbook->hasil = $request->hasil;
        $logbook->anggota1 = $request->anggota1;
        $logbook->anggota2 = $request->anggota2;
        $logbook->anggota3 = $request->anggota3;
        $logbook->anggota4 = $request->anggota4;
        $logbook->anggota5 = $request->anggota5;

        if ($request->hasFile('foto_kegiatan')) {
            $logbook->foto_kegiatan = $request->file('foto_kegiatan')->store('foto_kegiatan', 'public');
        }

        $logbook->save();

        return redirect()->route('mahasiswa.logbook')->with('success', 'Logbook berhasil diperbarui!');
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
