<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\RubrikPenilaian;
use App\Models\Pengampu;

class PenilaianController extends Controller
{
    // Admin - Tambah Rubrik Penilaian
    public function createRubrik(Request $request)
    {
        $request->validate([
            'metode_asesmen' => 'required|string',
            'aspek_penilaian' => 'required|string',
            'bobot' => 'required|numeric|min:0|max:1'
        ]);

        $rubrik = RubrikPenilaian::create($request->all());

        return response()->json(['message' => 'Rubrik berhasil ditambahkan', 'data' => $rubrik]);
    }

    // Dosen - Input Nilai Mahasiswa sesuai pengampu (tanpa auth)
    public function beriNilai(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|exists:data_mahasiswa,nim',
            'rubrik_id' => 'required|exists:rubrik_penilaian,id',
            'pengampu_id' => 'required|exists:pengampu,id',
            'score' => 'required|integer|min:1|max:4'
        ]);

        // Hapus validasi dosen_id untuk sementara, biar bisa tes bebas

        $nilai = NilaiMahasiswa::create($request->all());

        return response()->json(['message' => 'Nilai berhasil disimpan', 'data' => $nilai]);
    }

    // Lihat Nilai Mahasiswa (rekap per mahasiswa)
    public function getNilaiMahasiswa($nim)
    {
        $nilai = NilaiMahasiswa::with('rubrik')
                    ->where('nim', $nim)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'aspek_penilaian' => $item->rubrik->aspek_penilaian,
                            'bobot' => $item->rubrik->bobot,
                            'score' => $item->score,
                            'nilai_akhir_aspek' => $item->score * $item->rubrik->bobot,
                        ];
                    });

        $total = $nilai->sum('nilai_akhir_aspek');

        return response()->json([
            'nim' => $nim,
            'nilai' => $nilai,
            'total' => $total
        ]);
    }
}
