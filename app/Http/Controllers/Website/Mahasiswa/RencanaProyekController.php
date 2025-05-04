<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RencanaProyek;
use App\Models\TahapanPelaksanaan;
use App\Models\KebutuhanPeralatan;
use App\Models\Estimasi;
use App\Models\Tantangan;

class RencanaProyekController extends Controller
{
    public function create()
    {
        $id_tim = auth()->user()->id_tim;
        $rencanaProyek = RencanaProyek::where('id_tim', $id_tim)->first(); 
        return view('mahasiswa.semester4.rpp.rencana-proyek', compact('rencanaProyek'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        $id_tim = auth()->user()->id_tim;

        // Cek apakah sudah ada data rencana proyek untuk tim ini
        $rencanaProyek = RencanaProyek::where('id_tim', $id_tim)->first();

        if (!$rencanaProyek) {
            // Jika belum ada, buat data rencana proyek baru
            $rencanaProyek = RencanaProyek::create([
                'id_tim' => $id_tim,
                'judul_proyek' => $request->judul_proyek,
                'pengusul_proyek' => $request->pengusul_proyek,
                'manajer_proyek' => $request->manajer_proyek,
                'luaran' => $request->luaran,
                'sponsor' => $request->sponsor,
                'biaya' => $request->biaya,
                'klien' => $request->klien,
                'waktu' => $request->waktu,
                'ruang_lingkup' => $request->ruang_lingkup,
                'rancangan_sistem' => $request->rancangan_sistem,
            ]);
        }

        // Simpan data tahapan, peralatan, tantangan, dan estimasi secara otomatis
        $this->saveTahapanPelaksanaan($request, $rencanaProyek);
        $this->saveKebutuhanPeralatan($request, $rencanaProyek);
        $this->saveTantangan($request, $rencanaProyek);
        $this->saveEstimasi($request, $rencanaProyek);

        // Kirim respon autosave
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan secara otomatis.',
            'data' => $rencanaProyek
        ]);
    }

    // Fungsi untuk menyimpan tahapan pelaksanaan
    private function saveTahapanPelaksanaan(Request $request, $rencanaProyek)
    {
        foreach ($request->tahapan ?? [] as $index => $tahapan) {
            if ($tahapan || $request->minggu[$index] || $request->pic[$index] || $request->keterangan[$index]) {
                TahapanPelaksanaan::updateOrCreate(
                    ['rencana_proyek_id' => $rencanaProyek->id, 'nomor' => $index + 1],
                    [
                        'minggu' => $request->minggu[$index],
                        'tahapan' => $tahapan,
                        'pic' => $request->pic[$index],
                        'keterangan' => $request->keterangan[$index],
                    ]
                );
            }
        }
    }

    // Fungsi untuk menyimpan kebutuhan peralatan
    private function saveKebutuhanPeralatan(Request $request, $rencanaProyek)
    {
        foreach ($request->fase ?? [] as $index => $fase) {
            if ($fase || $request->peralatan[$index] || $request->bahan[$index]) {
                KebutuhanPeralatan::updateOrCreate(
                    ['rencana_proyek_id' => $rencanaProyek->id, 'nomor' => $index + 1],
                    [
                        'fase' => $fase,
                        'peralatan' => $request->peralatan[$index],
                        'bahan' => $request->bahan[$index],
                    ]
                );
            }
        }
    }

    // Fungsi untuk menyimpan tantangan
    private function saveTantangan(Request $request, $rencanaProyek)
    {
        foreach ($request->proses ?? [] as $index => $proses) {
            if ($proses || $request->isu[$index] || $request->level_resiko[$index] || $request->catatan_tantangan[$index]) {
                Tantangan::updateOrCreate(
                    ['rencana_proyek_id' => $rencanaProyek->id, 'nomor' => $index + 1],
                    [
                        'proses' => $proses,
                        'isu' => $request->isu[$index],
                        'level_resiko' => $request->level_resiko[$index],
                        'catatan' => $request->catatan_tantangan[$index],
                    ]
                );
            }
        }
    }

    // Fungsi untuk menyimpan estimasi
    private function saveEstimasi(Request $request, $rencanaProyek)
    {
        foreach ($request->uraian_pekerjaan ?? [] as $index => $uraian) {
            if ($uraian || $request->estimasi_waktu[$index] || $request->catatan_estimasi[$index]) {
                Estimasi::updateOrCreate(
                    ['rencana_proyek_id' => $rencanaProyek->id, 'fase' => $index + 1],
                    [
                        'uraian_pekerjaan' => $uraian,
                        'estimasi_waktu' => $request->estimasi_waktu[$index],
                        'catatan' => $request->catatan_estimasi[$index],
                    ]
                );
            }
        }
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'judul_proyek' => 'nullable|string|max:255',
            'pengusul_proyek' => 'nullable|string|max:255',
            'manajer_proyek' => 'nullable|string|max:255',
            'luaran' => 'nullable|string|max:255',
            'sponsor' => 'nullable|string|max:255',
            'biaya' => 'nullable|string|max:255',
            'klien' => 'nullable|string|max:255',
            'waktu' => 'nullable|string|max:255',
            'ruang_lingkup' => 'nullable|string|max:255',
            'rancangan_sistem' => 'nullable|string|max:255',

            'tahapan.*' => 'nullable|string|max:255',
            'minggu.*' => 'nullable|string|max:255',
            'pic.*' => 'nullable|string|max:255',
            'keterangan.*' => 'nullable|string|max:255',

            'fase.*' => 'nullable|string|max:255',
            'peralatan.*' => 'nullable|string|max:255',
            'bahan.*' => 'nullable|string|max:255',

            'proses.*' => 'nullable|string|max:255',
            'isu.*' => 'nullable|string|max:255',
            'level_resiko.*' => 'nullable|string|max:255',
            'catatan_tantangan.*' => 'nullable|string|max:255',

            'uraian_pekerjaan.*' => 'nullable|string|max:255',
            'estimasi_waktu.*' => 'nullable|string|max:255',
            'catatan_estimasi.*' => 'nullable|string|max:255',
        ]);
    }
}
