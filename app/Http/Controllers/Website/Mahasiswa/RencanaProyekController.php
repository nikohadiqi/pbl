<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RencanaProyek;

class RencanaProyekController extends Controller
{
    /**
     * Display the rencana proyek form with existing data if any.
     */
    public function index()
    {
        $rencanaProyek = RencanaProyek::first();
        return view('mahasiswa.semester.rpp.rencana-proyek', compact('rencanaProyek'));
    }

    /**
     * Show the form for creating or editing the rencana proyek.
     */
    public function showForm()
    {
        $rencanaProyek = RencanaProyek::first();
        return view('mahasiswa.semester.rpp.rencana-proyek', compact('rencanaProyek'));
    }

    /**
     * Store a newly created rencana proyek in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_proyek'        => 'nullable|string|max:255',
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
            'minggu'           => 'nullable|integer',
            'tahapan'          => 'nullable|string|max:255',
            'pic'              => 'nullable|string|max:255',
            'keterangan'       => 'nullable|string',
            'proses'           => 'nullable|string|max:255',
            'peralatan'        => 'nullable|string|max:255',
            'bahan'            => 'nullable|string|max:255',
            'tantangan'        => 'nullable|string|max:255',
            'level'            => 'nullable|string|max:255',
            'rencana_tindakan' => 'nullable|string',
            'catatan'          => 'nullable|string',
            'uraian_pekerjaan' => 'nullable|string',
            'perkiraan_biaya'  => 'nullable|numeric',
            'estimasi'         => 'nullable|string|max:255',
            'nama'             => 'nullable|string|max:255',
            'nim'              => 'nullable|string|max:255',
            'program_studi'    => 'nullable|string|max:255',
        ]);

        $rencanaProyek = RencanaProyek::create($validated);

        return redirect()->route('rencana-proyek.index')->with('success', 'Rencana Proyek berhasil disimpan.');
    }

    /**
     * Update the specified rencana proyek in storage.
     */
    public function update(Request $request, $id)
    {
        $rencanaProyek = RencanaProyek::find($id);

        if (!$rencanaProyek) {
            return redirect()->route('rencana-proyek.index')->with('error', 'Rencana Proyek tidak ditemukan.');
        }

        $validated = $request->validate([
            'id_proyek'        => 'nullable|string|max:255',
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
            'minggu'           => 'nullable|integer',
            'tahapan'          => 'nullable|string|max:255',
            'pic'              => 'nullable|string|max:255',
            'keterangan'       => 'nullable|string',
            'proses'           => 'nullable|string|max:255',
            'peralatan'        => 'nullable|string|max:255',
            'bahan'            => 'nullable|string|max:255',
            'tantangan'        => 'nullable|string|max:255',
            'level'            => 'nullable|string|max:255',
            'rencana_tindakan' => 'nullable|string',
            'catatan'          => 'nullable|string',
            'uraian_pekerjaan' => 'nullable|string',
            'perkiraan_biaya'  => 'nullable|numeric',
            'estimasi'         => 'nullable|string|max:255',
            'nama'             => 'nullable|string|max:255',
            'nim'              => 'nullable|string|max:255',
            'program_studi'    => 'nullable|string|max:255',
        ]);

        $rencanaProyek->update($validated);

        return redirect()->route('rencana-proyek.index')->with('success', 'Rencana Proyek berhasil diperbarui.');
    }
}
