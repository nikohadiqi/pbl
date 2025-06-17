<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel,  WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $requiredKeys = ['nim', 'nama', 'program_studi', 'kelas'];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $row)) {
                throw ValidationException::withMessages([
                    'file' => ["Kolom \"$key\" tidak ditemukan. Pastikan file Excel memiliki header (nim, nama, program_studi, kelas)"]
                ]);
            }
        }

        // Validasi format nama kelas, contoh: 1A, 2B, 3C
        if (!preg_match('/^([1-6])([A-Z])$/', $row['kelas'], $matches)) {
            throw ValidationException::withMessages([
                'file' => ["Format nama kelas tidak valid untuk \"{$row['kelas']}\". Gunakan format seperti: 1A, 2B, dst."]
            ]);
        }

        $kelasNama = $row['kelas'];
        $tingkat = (int)$matches[1];

        // Buat entri kelas jika belum ada
        Kelas::firstOrCreate(
            ['kelas' => $kelasNama],
            ['tingkat' => $tingkat]
        );

        // Simpan atau update data mahasiswa
        return Mahasiswa::updateOrCreate(
            ['nim' => $row['nim']],
            [
                'nama'          => $row['nama'],
                'program_studi' => $row['program_studi'],
                'dosen_wali'    => $row['dosen_wali'] ?? null,
                'status'        => $row['status'] ?? null,
                'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                'kelas'         => $kelasNama,
                'angkatan'      => $row['angkatan'] ?? null,
            ]
        );
    }
}
