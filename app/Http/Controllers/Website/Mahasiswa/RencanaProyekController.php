<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RencanaProyek;

class RencanaProyekController extends Controller
{
    public function create() {
        $rencanaProyek = RencanaProyek::all(); // or fetch existing record if necessary
        return view('mahasiswa.semester4.rpp.rencana-proyek', compact('rencanaProyek'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        RencanaProyek::create($request->all());

        return redirect()->back()->with('success', 'Rencana proyek berhasil disimpan.');
    }

    public function update(Request $request, $id_proyek)
    {
        $this->validateRequest($request);

        $rencanaProyek = RencanaProyek::findOrFail($id_proyek);
        $rencanaProyek->update($request->all());

        return redirect()->back()->with('success', 'Rencana proyek berhasil diperbarui.');
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'id_proyek'            => 'required|string|max:255',
            'judul_proyek'         => 'required|string',
            'pengusul_proyek'      => 'required|string',
            'luaran'               => 'required|string',
            'sponsor'              => 'required|string',
            'rancangan_sistem'     => 'required|string',
            'tahapan_pelaksanaan'  => 'required|string',
            'kebutuhan_peralatan'  => 'required|string',
            'tantangan'            => 'required|string',
            'waktu'                => 'required|string',
            'ruang_lingkup'        => 'required|string',
            'klien'                => 'required|string',
            'biaya'                => 'required|string',
            'biaya_proyek'         => 'required|string',
        ]);
    }
}
