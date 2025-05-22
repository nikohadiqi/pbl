<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\Anggota_Tim_Pbl;
use App\Models\TahapanPelaksanaanProyek;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LogbookController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $anggota = Anggota_Tim_Pbl::where('nim', $mahasiswa->nim)->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Data tim tidak ditemukan.');
        }

        $logbooks = Logbook::where('kode_tim', $anggota->kode_tim)->get();
        $timPbl = $anggota->tim; // relasi ke TimPbl

        $tahapans = TahapanPelaksanaanProyek::where('periode_id', $timPbl->periode)
            ->orderBy('id')
            ->take(16) // batas maksimal 16
            ->get();

        $scores = [];
        foreach ($tahapans as $index => $tahapan) {
            $scores[$index + 1] = $tahapan->score ?? 100;
        }

        $selectedLogbook = null;
        if ($request->has('selectedId')) {
            $selectedLogbook = Logbook::where('kode_tim', $anggota->kode_tim)
                ->where('minggu', $request->input('selectedId'))
                ->first();
        }

        return view('mahasiswa.logbook.logbook', compact('logbooks', 'selectedLogbook', 'tahapans', 'scores'));
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'minggu' => 'nullable|integer|min:1|max:16', // Minggu wajib diisi
            'aktivitas' => 'required|string|max:255',   // Aktivitas wajib diisi
            'hasil' => 'required|string|max:255',       // Hasil wajib diisi
            'progress' => 'required|integer|between:0,100', // Progress wajib diisi
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Foto kegiatan nullable
            'anggota1' => 'nullable|string|max:255',     // Anggota1 nullable
            'anggota2' => 'nullable|string|max:255',     // Anggota2 nullable
            'anggota3' => 'nullable|string|max:255',     // Anggota3 nullable
            'anggota4' => 'nullable|string|max:255',     // Anggota4 nullable
            'anggota5' => 'nullable|string|max:255',     // Anggota5 nullable
        ]);
        // Ambil data mahasiswa yang sedang login
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Ambil score maksimal dari TPP sesuai tahapan_id
        $tahapan = TahapanPelaksanaanProyek::find($request->tahapan_id);
        if (!$tahapan) {
            return redirect()->back()->withErrors(['tahapan_id' => 'Tahapan tidak ditemukan']);
        }

        $maxProgress = intval($tahapan->score); // misal score disimpan dalam persen seperti 5 (untuk 5%)

        // Batasi progress input user supaya tidak lebih dari score
        $inputProgress = intval($request->progress);
        if ($inputProgress > $maxProgress) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['progress' => "Progress tidak boleh lebih dari {$maxProgress}% sesuai score tahapan."]);
        }

        // Update atau create logbook
        $logbook = Logbook::updateOrCreate(
            ['kode_tim' => $mahasiswa->kode_tim, 'minggu' => $request->minggu],
            [
                'aktivitas' => $request->aktivitas,
                'hasil' => $request->hasil,
                'progress' => $inputProgress,
                'anggota1' => $request->anggota1,
                'anggota2' => $request->anggota2,
                'anggota3' => $request->anggota3,
                'anggota4' => $request->anggota4,
                'anggota5' => $request->anggota5,
            ]
        );

        // Upload foto kegiatan jika ada
        if ($request->hasFile('foto_kegiatan')) {
            $file = $request->file('foto_kegiatan');
            $filePath = $file->store('foto_kegiatan', 'public');
            $logbook->foto_kegiatan = $filePath;
            $logbook->save();
        }

        Alert::success('Berhasil!', 'Logbook berhasil disimpan!');
        return redirect()->route('mahasiswa.logbook');
    }
}
