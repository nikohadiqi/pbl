<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Pengampu;

class PenilaianController extends Controller
{
    private $aspek = [
        'critical_thinking', 'kolaborasi', 'kreativitas', 'komunikasi', 'fleksibilitas',
        'kepemimpinan', 'produktifitas', 'social_skill', 'konten', 'tampilan_visual_presentasi',
        'kosakata', 'tanya_jawab', 'mata_gerak_tubuh', 'penulisan_laporan', 'pilihan_kata',
        'konten_2', 'sikap_kerja', 'proses', 'kualitas'
    ];

    private $bobot = [
        'critical_thinking' => 5,
        'kolaborasi' => 5,
        'kreativitas' => 5,
        'komunikasi' => 5,
        'fleksibilitas' => 5,
        'kepemimpinan' => 5,
        'produktifitas' => 10,
        'social_skill' => 2,
        'konten' => 2,
        'tampilan_visual_presentasi' => 2,
        'kosakata' => 2,
        'tanya_jawab' => 2,
        'mata_gerak_tubuh' => 2,
        'penulisan_laporan' => 3,
        'pilihan_kata' => 2,
        'konten_2' => 2,
        'sikap_kerja' => 8,
        'proses' => 15,
        'kualitas' => 15
    ];

    /**
     * Simpan nilai mahasiswa
     */
    public function beriNilai(Request $request)
    {
        $rules = [
            'nim' => 'required|string|exists:data_mahasiswa,nim',
            'pengampu_id' => 'required|exists:pengampu,id',
        ];

        foreach ($this->aspek as $item) {
            $rules[$item] = 'required|numeric|min:1|max:4';
        }

        $validated = $request->validate($rules);

        // Pastikan tidak ada duplikat penilaian (opsional)
        $existing = NilaiMahasiswa::where('nim', $validated['nim'])
            ->where('pengampu_id', $validated['pengampu_id'])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Nilai sudah pernah diberikan untuk NIM dan pengampu ini.'
            ], 409);
        }

        $nilai = NilaiMahasiswa::create(array_map('strval', $validated));

        return response()->json([
            'message' => 'Nilai berhasil disimpan',
            'data' => $nilai
        ]);
    }

    /**
     * Ambil nilai mahasiswa dan hitung rekap
     */
    public function getNilaiMahasiswa($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return response()->json([
                'message' => 'Mahasiswa tidak ditemukan',
                'nim' => $nim
            ], 404);
        }

        $data = NilaiMahasiswa::where('nim', $nim)->with('pengampu')->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Belum ada nilai untuk mahasiswa ini',
                'nim' => $nim
            ], 404);
        }

        $rekap = $data->map(function ($item) {
            $totalBobot = 0;
            $totalSkor = 0;
            $rincian = [];

            foreach ($this->bobot as $aspek => $bobot) {
                $nilai = (int) $item->$aspek;
                $skor = $nilai * $bobot;
                $totalSkor += $skor;
                $totalBobot += $bobot;

                $rincian[$aspek] = [
                    'nilai' => $nilai,
                    'bobot' => $bobot,
                    'skor' => round($skor / 4, 2)
                ];
            }

            $nilaiAkhir = round($totalSkor / $totalBobot * 100, 2); // Skor akhir sebagai persentase

            return [
                'pengampu_id' => $item->pengampu_id,
                'mata_kuliah' => $item->pengampu->mata_kuliah ?? null,
                'nilai_akhir' => $nilaiAkhir,
                'detail' => $rincian
            ];
        });

        return response()->json([
            'nim' => $nim,
            'nama' => $mahasiswa->nama,
            'rekap' => $rekap
        ]);
    }
}
