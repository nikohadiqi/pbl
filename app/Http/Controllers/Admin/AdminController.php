<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\PeriodePBL;
use App\Models\TimPBL;

class AdminController extends Controller
{
    /**
     * Tambah Dosen
     */
    public function tambahDosen(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|unique:dosen,nip',
            'nama' => 'required|string',
        ]);

        $dosen = Dosen::create($request->all());

        return response()->json([
            'message' => 'Dosen berhasil ditambahkan!',
            'data' => $dosen
        ], 201);
    }

    /**
     * Tambah Mahasiswa
     */
    public function tambahMahasiswa(Request $request)
    {
        $request->validate([
            'id_tahun' => 'required|string',
            'nim' => 'required|string|unique:mahasiswa,nim',
            'nama' => 'required|string',
        ]);

        $mahasiswa = Mahasiswa::create($request->all());

        return response()->json([
            'message' => 'Mahasiswa berhasil ditambahkan!',
            'data' => $mahasiswa
        ], 201);
    }

    /**
     * Tambah Periode PBL
     */
    public function tambahPeriodePBL(Request $request)
    {
        $request->validate([
            'semester' => 'required|string|in:4,5',
            'tahun' => 'required|string',
        ]);

        $periode = PeriodePBL::create($request->all());

        return response()->json([
            'message' => 'Periode PBL berhasil ditambahkan!',
            'data' => $periode
        ], 201);
    }
/**
     * Menambahkan Ketua Tim dan Anggota Tim berdasarkan Nama Mahasiswa
     */
    public function tambahTimPBL(Request $request)
    {
        $request->validate([
            'periode_pbl' => 'required|exists:periodepbl,id',
            'kelas' => 'required|string',
            'code_tim' => 'required|string|unique:timpbl,code_tim',
            'ketua_tim_nama' => 'required|string',
            'anggota_tim_nama' => 'required|array|min:1',
            'anggota_tim_nama.*' => 'string',
        ]);

        // Cari ketua tim berdasarkan nama
        $ketuaTim = Mahasiswa::where('nama', $request->ketua_tim_nama)->first();
        if (!$ketuaTim) {
            return response()->json([
                'message' => 'Ketua Tim tidak ditemukan dalam data mahasiswa.'
            ], 404);
        }

        // Cari anggota tim berdasarkan nama
        $anggotaTim = Mahasiswa::whereIn('nama', $request->anggota_tim_nama)->get();
        if ($anggotaTim->count() !== count($request->anggota_tim_nama)) {
            return response()->json([
                'message' => 'Beberapa anggota tim tidak ditemukan dalam data mahasiswa.',
                'anggota_ditemukan' => $anggotaTim->pluck('nama')
            ], 404);
        }

        // Simpan ke database
        $timPBL = TimPBL::create([
            'periode_pbl' => $request->periode_pbl,
            'kelas' => $request->kelas,
            'code_tim' => $request->code_tim,
            'ketua_tim' => $ketuaTim->id,
            'anggota_tim' => json_encode($anggotaTim->pluck('id')->toArray()),
        ]);

        return response()->json([
            'message' => 'Tim PBL berhasil ditambahkan!',
            'data' => [
                'id' => $timPBL->id,
                'periode_pbl' => $timPBL->periode_pbl,
                'kelas' => $timPBL->kelas,
                'code_tim' => $timPBL->code_tim,
                'ketua_tim' => [
                    'id' => $ketuaTim->id,
                    'nama' => $ketuaTim->nama
                ],
                'anggota_tim' => $anggotaTim->map(function ($anggota) {
                    return [
                        'id' => $anggota->id,
                        'nama' => $anggota->nama
                    ];
                }),
            ]
        ], 201);
    }

    /**
     * Menampilkan Semua Data Tim PBL
     */
    public function getTimPBL()
    {
        $timPBL = TimPBL::with(['periodePBL', 'ketuaTim'])->get();

        return response()->json([
            'message' => 'Data Tim PBL',
            'data' => $timPBL
        ]);
    }
}
