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
        // Retrieve the authenticated user using the 'mahasiswa' guard
        $nim = Auth::guard('mahasiswa')->user()->nim;

        // Retrieve the first 'Anggota_Tim_Pbl' for the authenticated 'nim'
        $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

        if ($anggota) {
            // Retrieve the 'kode_tim' associated with the 'nim'
            $kode_tim = $anggota->kode_tim;

            // Retrieve the first RencanaProyek for the authenticated 'kode_tim'
            $rencanaProyek = RencanaProyek::where('kode_tim', $kode_tim)->first();
        } else {
            // Handle the case where the 'Anggota_Tim_Pbl' is not found
            $rencanaProyek = null;
        }

        // Return the view and pass the rencanaProyek data to it
        return view('mahasiswa.semester4.rpp.rencana-proyek', compact('rencanaProyek'));
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
}