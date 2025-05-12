<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\Tpp_sem4;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
   public function index(Request $request)
{
    $mahasiswa = Auth::guard('mahasiswa')->user();
    $logbooks = Logbook::where('kode_tim', $mahasiswa->kode_tim)->get();
    $tahapans = Tpp_sem4::all(); // Ambil data tahapan

    // Select the logbook for the week
    $selectedLogbook = null;
    if ($request->has('selectedId')) {
        $selectedLogbook = Logbook::where('kode_tim', $mahasiswa->kode_tim)
                                  ->where('minggu', $request->input('selectedId'))
                                  ->first();
    }

    return view('mahasiswa.semester4.logbook.logbook', compact('logbooks', 'selectedLogbook', 'tahapans'));
}
public function create()
{
    // Ensure you are creating a logbook for a specific week. 
    // We won't use Logbook::first() here since this is a weekly logbook.
    return view('mahasiswa.semester4.logbook.create');
}

public function store(Request $request)
{
    // Validasi input dari form
    $validated = $request->validate([
        'minggu' => 'nullable|integer|min:1|max:16', // Minggu wajib diisi
        'aktivitas' => 'nullable|string|max:255',   // Aktivitas wajib diisi
        'hasil' => 'nullable|string|max:255',       // Hasil wajib diisi
        'progress' => 'nullable|integer|between:0,100', // Progress wajib diisi
        'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Foto kegiatan nullable
        'anggota1' => 'nullable|string|max:255',     // Anggota1 nullable
        'anggota2' => 'nullable|string|max:255',     // Anggota2 nullable
        'anggota3' => 'nullable|string|max:255',     // Anggota3 nullable
        'anggota4' => 'nullable|string|max:255',     // Anggota4 nullable
        'anggota5' => 'nullable|string|max:255',     // Anggota5 nullable
    ]);

    // Ambil data mahasiswa yang sedang login
    $mahasiswa = Auth::guard('mahasiswa')->user();

    // Cek apakah logbook untuk minggu ini sudah ada, jika ada update, jika tidak buat baru
    $logbook = Logbook::updateOrCreate(
        ['kode_tim' => $mahasiswa->kode_tim, 'minggu' => $request->minggu],
        [
            'aktivitas' => $request->aktivitas,
            'hasil' => $request->hasil,
            'progress' => $request->progress,
            'anggota1' => $request->anggota1,
            'anggota2' => $request->anggota2,
            'anggota3' => $request->anggota3,
            'anggota4' => $request->anggota4,
            'anggota5' => $request->anggota5,
        ]
    );

    // Cek apakah ada file foto kegiatan yang di-upload
    if ($request->hasFile('foto_kegiatan')) {
        $file = $request->file('foto_kegiatan');
        $filePath = $file->store('foto_kegiatan', 'public');
        // Update field foto_kegiatan jika ada file yang di-upload
        $logbook->foto_kegiatan = $filePath;
        $logbook->save();
    }

    // Redirect kembali ke halaman logbook dengan pesan sukses
    return redirect()->route('mahasiswa.logbook')->with('success', 'Logbook berhasil disimpan!');
}
}