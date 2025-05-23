<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\Anggota_Tim_Pbl;
use App\Models\PeriodePBL;
use App\Models\TahapanPelaksanaanProyek;
use App\Models\TimPbl;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LogbookController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $kodeTim = getKodeTimByAuth();

        if (!$kodeTim) {
            return redirect()->back()->with('error', 'Data tim periode aktif tidak ditemukan.');
        }

        $logbooks = Logbook::where('kode_tim', $kodeTim)->get();

        $timPbl = TimPbl::where('kode_tim', $kodeTim)->first();

        $tahapans = TahapanPelaksanaanProyek::where('periode_id', $timPbl->periode)
            ->orderBy('id')
            ->take(16)
            ->get();

        $scores = [];
        foreach ($tahapans as $index => $tahapan) {
            $scores[$index + 1] = $tahapan->score ?? 100;
        }

        $selectedLogbook = null;
        if ($request->has('selectedId')) {
            $selectedLogbook = Logbook::where('kode_tim', $kodeTim)
                ->where('minggu', $request->input('selectedId'))
                ->first();
        }

        return view('mahasiswa.logbook.logbook', compact('logbooks', 'selectedLogbook', 'tahapans', 'scores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'minggu' => 'nullable|integer|min:1|max:16',
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

        $kodeTim = $this->getKodeTimByAuth();
        if (!$kodeTim) {
            return redirect()->back()->with('error', 'Data tim periode aktif tidak ditemukan.');
        }

        $tahapan = TahapanPelaksanaanProyek::find($request->tahapan_id);
        if (!$tahapan) {
            return redirect()->back()->withErrors(['tahapan_id' => 'Tahapan tidak ditemukan']);
        }

        $maxProgress = intval($tahapan->score);

        if ($validated['progress'] > $maxProgress) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['progress' => "Progress tidak boleh lebih dari {$maxProgress}% sesuai score tahapan."]);
        }

        $logbook = Logbook::updateOrCreate(
            ['kode_tim' => $kodeTim, 'minggu' => $validated['minggu']],
            [
                'aktivitas' => $validated['aktivitas'],
                'hasil' => $validated['hasil'],
                'progress' => $validated['progress'],
                'anggota1' => $validated['anggota1'] ?? null,
                'anggota2' => $validated['anggota2'] ?? null,
                'anggota3' => $validated['anggota3'] ?? null,
                'anggota4' => $validated['anggota4'] ?? null,
                'anggota5' => $validated['anggota5'] ?? null,
            ]
        );

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
