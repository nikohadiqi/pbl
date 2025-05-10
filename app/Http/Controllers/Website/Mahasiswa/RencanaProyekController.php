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
       // Validate the data
$validated = $request->validate([
    'judul_proyek' => 'nullable|string',
    'pengusul_proyek' => 'nullable|string',
    'manajer_proyek' => 'nullable|string',
    'luaran' => 'nullable|string',
    'sponsor' => 'nullable|string',
    'biaya' => 'nullable|string',
    'klien' => 'nullable|string',
    'waktu' => 'nullable|string',
    'ruang_lingkup' => 'nullable|string', // This field is now nullable and string
    'rancangan_sistem' => 'nullable|string', // This field is now nullable and string
    'minggu' => 'nullable|array', // These fields are now nullable arrays
    'tahapan' => 'nullable|array',
    'pic' => 'nullable|array',
    'keterangan' => 'nullable|array',
    'nomor' => 'nullable|array',
    'fase' => 'nullable|array',
    'peralatan' => 'nullable|array',
    'bahan' => 'nullable|array',
    'proses' => 'nullable|array',
    'isu' => 'nullable|array',
    'level_resiko' => 'nullable|array',
    'catatan' => 'nullable|array',
    'uraian_pekerjaan' => 'nullable|array',
    'estimasi_waktu' => 'nullable|array',
]);

    
        // Store the data in the database
        $rencanaProyek = new RencanaProyek();
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
    
        // Save tahapan pelaksanaan
        $this->saveTahapanPelaksanaan($request, $rencanaProyek);
    
        // Save kebutuhan peralatan
        $this->saveKebutuhanPeralatan($request, $rencanaProyek);
    
        // Save tantangan
        $this->saveTantangan($request, $rencanaProyek);
    
        // Save estimasi
        $this->saveEstimasi($request, $rencanaProyek);
    
        // Save the main rencanaProyek
        $rencanaProyek->save();
    
        return redirect()->route('mahasiswa.rpp.rencana-proyek.store')
                         ->with('success', 'Data berhasil disimpan!')
                         ->with('rencanaProyek', $rencanaProyek); // Pass data back to the view
    }
}