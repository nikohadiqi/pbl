<?php

namespace App\Http\Controllers\API\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RencanaProyek;
use App\Models\RencanaProyekWaktu;
use App\Models\RencanaProyekFase;
use App\Models\RencanaProyekRisiko;
use App\Models\RencanaProyekBiaya;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RencanaProyekController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'judul_proyek' => 'required|string',
            'pengusul_proyek' => 'required|string',
            'manajer_proyek' => 'required|string',
            'luaran' => 'required|string',
            'sponsor' => 'required|string',
            'biaya' => 'required|string',
            'klien' => 'required|string',
            'waktu' => 'required|string',
            'ruang_lingkup' => 'required|string',
            'rancangan_sistem' => 'required|string',

            // Validasi array opsional (jika dikirim)
            'tahapan' => 'nullable|array',
            'minggu' => 'nullable|array',
            'pic' => 'nullable|array',
            'keterangan' => 'nullable|array',

            'fase' => 'nullable|array',
            'peralatan' => 'nullable|array',
            'bahan' => 'nullable|array',

            'proses' => 'nullable|array',
            'isu' => 'nullable|array',
            'level_resiko' => 'nullable|array',
            'catatan_tantangan' => 'nullable|array',

            'uraian_pekerjaan' => 'nullable|array',
            'estimasi_waktu' => 'nullable|array',
            'catatan_estimasi' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $id_tim = Auth::user()->id_tim;

            // Simpan Rencana Proyek Utama
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

            // Simpan Tahapan Waktu
            if ($request->has('tahapan')) {
                foreach ($request->tahapan as $i => $tahapan) {
                    RencanaProyekWaktu::create([
                        'id_rencana_proyek' => $rencanaProyek->id,
                        'tahapan' => $tahapan,
                        'minggu' => $request->minggu[$i] ?? null,
                        'pic' => $request->pic[$i] ?? null,
                        'keterangan' => $request->keterangan[$i] ?? null,
                    ]);
                }
            }

            // Simpan Fase Peralatan Bahan
            if ($request->has('fase')) {
                foreach ($request->fase as $i => $fase) {
                    RencanaProyekFase::create([
                        'id_rencana_proyek' => $rencanaProyek->id,
                        'fase' => $fase,
                        'peralatan' => $request->peralatan[$i] ?? null,
                        'bahan' => $request->bahan[$i] ?? null,
                    ]);
                }
            }

            // Simpan Risiko
            if ($request->has('proses')) {
                foreach ($request->proses as $i => $proses) {
                    RencanaProyekRisiko::create([
                        'id_rencana_proyek' => $rencanaProyek->id,
                        'proses' => $proses,
                        'isu' => $request->isu[$i] ?? null,
                        'level_resiko' => $request->level_resiko[$i] ?? null,
                        'catatan_tantangan' => $request->catatan_tantangan[$i] ?? null,
                    ]);
                }
            }

            // Simpan Estimasi Biaya
            if ($request->has('uraian_pekerjaan')) {
                foreach ($request->uraian_pekerjaan as $i => $uraian) {
                    RencanaProyekBiaya::create([
                        'id_rencana_proyek' => $rencanaProyek->id,
                        'uraian_pekerjaan' => $uraian,
                        'estimasi_waktu' => $request->estimasi_waktu[$i] ?? null,
                        'catatan_estimasi' => $request->catatan_estimasi[$i] ?? null,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Rencana proyek berhasil disimpan.',
                'data' => $rencanaProyek
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal menyimpan rencana proyek.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
