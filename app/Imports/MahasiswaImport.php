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

        // Validasi format nama kelas
        if (!preg_match('/^[1-4][A-Z]$/', $row['kelas'])) {
            throw ValidationException::withMessages([
                'file' => ["Format nama kelas tidak valid untuk \"{$row['kelas']}\". Hanya diperbolehkan format seperti: 1A, 2A, 3A, 4A"]
            ]);
        }

        // Buat entri kelas jika belum ada
        Kelas::firstOrCreate([
            'kelas' => $row['kelas'],
        ]);

        // Simpan atau update data mahasiswa
        return Mahasiswa::updateOrCreate(
            ['nim' => $row['nim']],
            [
                'nama'          => $row['nama'],
                'program_studi' => $row['program_studi'],
                'dosen_wali'    => $row['dosen_wali'] ?? null,
                'status'        => $row['status'] ?? null,
                'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                'kelas'         => $row['kelas'],
                'angkatan'      => $row['angkatan'] ?? null,
            ]
        );
    }
}
