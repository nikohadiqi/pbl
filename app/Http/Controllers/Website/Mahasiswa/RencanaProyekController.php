<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RencanaProyek;
use App\Models\TahapanPelaksanaan;
use App\Models\KebutuhanPeralatan;
use App\Models\Estimasi;
use App\Models\Tantangan;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota_Tim_Pbl;

class RencanaProyekController extends Controller
{
    public function create()
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;

        // Retrieve the first 'Anggota_Tim_Pbl' for the authenticated 'nim'
        $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

        if ($anggota) {
            // Retrieve the 'kode_tim' associated with the 'nim'
            $kode_tim = $anggota->kode_tim;

            // Retrieve the first RencanaProyek for the authenticated 'kode_tim'
            $rencanaProyek = RencanaProyek::where('kode_tim', $kode_tim)->first();
            $tahapanPelaksanaan = TahapanPelaksanaan::where('kode_tim', $kode_tim)->get();
            $KebutuhanPeralatan = KebutuhanPeralatan::where('kode_tim', $kode_tim)->get();
            $Tantangan = Tantangan::where('kode_tim', $kode_tim)->get();
        } else {
            $rencanaProyek = null;
        }
        return view('mahasiswa.semester4.rpp.rencana-proyek', compact(
            'rencanaProyek', 
            'tahapanPelaksanaan', 
            'KebutuhanPeralatan', 
            'Tantangan'
));

    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'judul_proyek' => 'nullable|string',
        'pengusul_proyek' => 'nullable|string',
        'manajer_proyek' => 'nullable|string',
        'luaran' => 'nullable|string',
        'sponsor' => 'nullable|string',
        'biaya' => 'nullable|string',
        'klien' => 'nullable|string',
        'waktu' => 'nullable|string',
        'ruang_lingkup' => 'nullable|string',
        'rancangan_sistem' => 'nullable|string',
    ]);

    $nim = Auth::guard('mahasiswa')->user()->nim;
    $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

    if (!$anggota) {
        return redirect()->back()->with('error', 'Tim tidak ditemukan!');
    }

    $kode_tim = $anggota->kode_tim;

    // Update jika sudah ada
    $rencanaProyek = RencanaProyek::firstOrNew(['kode_tim' => $kode_tim]);

    $rencanaProyek->judul_proyek = $request->judul_proyek;
    $rencanaProyek->pengusul_proyek = $request->pengusul_proyek;
    $rencanaProyek->manajer_proyek = $request->manajer_proyek;
    $rencanaProyek->luaran = $request->luaran;
    $rencanaProyek->sponsor = $request->sponsor;
    $rencanaProyek->biaya = $request->biaya;
    $rencanaProyek->klien = $request->klien;
    $rencanaProyek->waktu = $request->waktu;
    $rencanaProyek->ruang_lingkup = $request->ruang_lingkup;
    $rencanaProyek->rancangan_sistem = $request->rancangan_sistem;
    $rencanaProyek->kode_tim = $kode_tim;

    $rencanaProyek->save();

    return redirect()->route('mahasiswa.rpp.rencana-proyek.create')->with('success', 'Data berhasil disimpan atau diperbarui!');
}

public function storeTahapanPelaksanaan(Request $request)
{
    $validated = $request->validate([
        'minggu.*' => 'required|integer',
        'tahapan.*' => 'required|string',
        'pic.*' => 'required|string',
        'keterangan.*' => 'nullable|string',
    ]);

    $nim = Auth::guard('mahasiswa')->user()->nim;
    $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

    if (!$anggota) {
        return back()->with('error', 'Tim tidak ditemukan!');
    }

    $kode_tim = $anggota->kode_tim;

    // Hapus data lama dulu (jika perlu update)
    TahapanPelaksanaan::where('kode_tim', $kode_tim)->delete();

    // Simpan ulang
    for ($i = 0; $i < count($request->minggu); $i++) {
        TahapanPelaksanaan::create([
            'kode_tim' => $kode_tim,
            'minggu' => $request->minggu[$i],
            'tahapan' => $request->tahapan[$i],
            'pic' => $request->pic[$i],
            'keterangan' => $request->keterangan[$i],
        ]);
    }

    return redirect()->back()->with(['success' => 'Tahapan Pelaksanaan disimpan.', 'active_step' => 'step2']);
}

public function storeKebutuhanPeralatan(Request $request)
{
    $validated = $request->validate([
        'nomor.*' => 'required|integer',
        'fase.*' => 'required|string',
        'peralatan.*' => 'nullable|string',
        'bahan.*' => 'nullable|string',
    ]);

    $nim = Auth::guard('mahasiswa')->user()->nim;
    $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

    if (!$anggota) {
        return back()->with('error', 'Tim tidak ditemukan!');
    }

    $kode_tim = $anggota->kode_tim;

    // Hapus data lama
    KebutuhanPeralatan::where('kode_tim', $kode_tim)->delete();

    // Simpan data baru
    for ($i = 0; $i < count($request->nomor); $i++) {
        KebutuhanPeralatan::create([
            'kode_tim' => $kode_tim,
            'nomor' => $request->nomor[$i],
            'fase' => $request->fase[$i],
            'peralatan' => $request->peralatan[$i],
            'bahan' => $request->bahan[$i],
        ]);
    }

    return redirect()->back()->with(['success' => 'Kebutuhan Peralatan berhasil disimpan.', 'active_step' => 'step3']);
}
public function storeTantangan(Request $request)
{
    $validated = $request->validate([
        'nomor.*' => 'required|integer',
        'proses.*' => 'required|string',
        'isu.*' => 'nullable|string',
        'level_resiko.*' => 'nullable|string',
        'catatan.*' => 'nullable|string',
    ]);

    $nim = Auth::guard('mahasiswa')->user()->nim;
    $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

    if (!$anggota) {
        return back()->with('error', 'Tim tidak ditemukan!');
    }

    $kode_tim = $anggota->kode_tim;

    // Hapus data lama
    Tantangan::where('kode_tim', $kode_tim)->delete();

    // Simpan data baru
    for ($i = 0; $i < count($request->nomor); $i++) {
        Tantangan::create([
            'kode_tim' => $kode_tim,
            'nomor' => $request->nomor[$i],
            'proses' => $request->proses[$i],
            'isu' => $request->isu[$i],
            'level_resiko' => $request->level_resiko[$i],
            'catatan' => $request->catatan[$i],
        ]);
    }

    return redirect()->back()->with(['success' => 'Tantangan berhasil disimpan.', 'active_step' => 'step4']);
}
}