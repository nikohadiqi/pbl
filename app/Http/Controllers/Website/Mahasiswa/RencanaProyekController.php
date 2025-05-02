<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RencanaProyek;
use App\Models\TahapanPelaksanaan;
use App\Models\KebutuhanPeralatan;

class RencanaProyekController extends Controller
{
    public function create() {
        $rencanaProyek = RencanaProyek::all(); // or fetch existing record if necessary
        return view('mahasiswa.semester4.rpp.rencana-proyek', compact('rencanaProyek'));
    }

    public function store(Request $request)
{
    $this->validateRequest($request);

    // Menyimpan data rencana proyek
    $rencanaProyek = RencanaProyek::create($request->all());

    // Simpan Tahapan Pelaksanaan
    if ($request->has('tahapan')) {
        foreach ($request->tahapan as $index => $tahapan) {
            if ($tahapan || $request->minggu[$index] || $request->pic[$index] || $request->keterangan[$index]) {
                TahapanPelaksanaan::create([
                    'rencana_proyek_id' => $rencanaProyek->id,
                    'minggu'            => $request->minggu[$index],
                    'tahapan'           => $tahapan,
                    'pic'               => $request->pic[$index],
                    'keterangan'        => $request->keterangan[$index],
                ]);
            }
        }
    }

    // Simpan Kebutuhan Peralatan
    if ($request->has('fase')) {
        foreach ($request->fase as $index => $fase) {
            if ($fase || $request->peralatan[$index] || $request->bahan[$index]) {
                KebutuhanPeralatan::create([
                    'rencana_proyek_id' => $rencanaProyek->id,
                    'nomor'             => $index + 1,
                    'fase'              => $fase,
                    'peralatan'         => $request->peralatan[$index],
                    'bahan'             => $request->bahan[$index],
                ]);
            }
        }
    }

    return redirect()->back()->with('success', 'Rencana proyek berhasil disimpan.');
}


public function update(Request $request, $id_proyek)
{
    $this->validateRequest($request);

    $rencanaProyek = RencanaProyek::findOrFail($id_proyek);
    $rencanaProyek->update($request->all());

    // Hapus data lama dari Tahapan Pelaksanaan dan Kebutuhan Peralatan
    TahapanPelaksanaan::where('rencana_proyek_id', $id_proyek)->delete();
    KebutuhanPeralatan::where('rencana_proyek_id', $id_proyek)->delete();

    // Simpan ulang Tahapan Pelaksanaan
    if ($request->has('tahapan')) {
        foreach ($request->tahapan as $index => $tahapan) {
            if ($tahapan || $request->minggu[$index] || $request->pic[$index] || $request->keterangan[$index]) {
                TahapanPelaksanaan::create([
                    'rencana_proyek_id' => $id_proyek,
                    'minggu'            => $request->minggu[$index],
                    'tahapan'           => $tahapan,
                    'pic'               => $request->pic[$index],
                    'keterangan'        => $request->keterangan[$index],
                ]);
            }
        }
    }

    // Simpan ulang Kebutuhan Peralatan
    if ($request->has('fase')) {
        foreach ($request->fase as $index => $fase) {
            if ($fase || $request->peralatan[$index] || $request->bahan[$index]) {
                KebutuhanPeralatan::create([
                    'rencana_proyek_id' => $id_proyek,
                    'nomor'             => $index + 1,
                    'fase'              => $fase,
                    'peralatan'         => $request->peralatan[$index],
                    'bahan'             => $request->bahan[$index],
                ]);
            }
        }
    }

    return redirect()->back()->with('success', 'Rencana proyek berhasil diperbarui.');
}
private function validateRequest(Request $request)
{
    $request->validate([
        'id_proyek'            => 'required|string|max:255',
        'judul_proyek'         => 'nullable|string|max:255',
        'pengusul_proyek'      => 'nullable|string|max:255',
        'luaran'               => 'nullable|string|max:255',
        'sponsor'              => 'nullable|string|max:255',
        'rancangan_sistem'     => 'nullable|string|max:255',
        'tantangan'            => 'nullable|string|max:255',
        'waktu'                => 'nullable|string|max:255',
        'ruang_lingkup'        => 'nullable|string|max:255',
        'klien'                => 'nullable|string|max:255',
        'biaya'                => 'nullable|string|max:255',
        'biaya_proyek'         => 'nullable|string|max:255',
        // Validasi Tahapan Pelaksanaan
        'tahapan.*'            => 'nullable|string|max:255',
        'minggu.*'             => 'nullable|string|max:255',
        'pic.*'                => 'nullable|string|max:255',
        'keterangan.*'         => 'nullable|string|max:255',
        // Validasi Kebutuhan Peralatan
        'fase.*'               => 'nullable|string|max:255',
        'peralatan.*'          => 'nullable|string|max:255',
        'bahan.*'              => 'nullable|string|max:255',
    ]);
}

}
