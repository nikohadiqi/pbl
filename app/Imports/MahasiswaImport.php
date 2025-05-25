<?php

namespace App\Imports;

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
        // Daftar header yang wajib ada
        $requiredKeys = ['nim', 'nama', 'program_studi', 'kelas'];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $row)) {
                throw ValidationException::withMessages([
                    'file' => ["Kolom \"$key\" tidak ditemukan. Pastikan file Excel memiliki header (nim, nama, program_studi, kelas)"]
                ]);
            }
        }

        return Mahasiswa::updateOrCreate(
            ['nim' => $row['nim']],
            [
                'nama'          => $row['nama'],
                'program_studi' => $row['program_studi'],
                'dosen_wali'    => $row['dosen_wali'],
                'status'        => $row['status'] ?? null,
                'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                'kelas'         => $row['kelas'],
                'angkatan'      => $row['angkatan'] ?? null,
            ]
        );
    }
}
