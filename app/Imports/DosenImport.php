<?php

namespace App\Imports;

use App\Models\Dosen;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Validasi header
        $requiredKeys = ['nip', 'nama', 'no_telp', 'email', 'prodi', 'jurusan'];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $row)) {
                throw ValidationException::withMessages([
                    'file' => ["Kolom \"$key\" tidak ditemukan. Pastikan file Excel memiliki header yang benar."]
                ]);
            }
        }

        return Dosen::updateOrCreate(
            ['nip' => $row['nip']],
            [
                'nama'          => $row['nama'],
                'no_telp'       => $row['no_telp'],
                'email'         => $row['email'],
                'prodi'         => $row['prodi'],
                'jurusan'       => $row['jurusan'],
                'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                'status_dosen'  => $row['status_dosen'] ?? null,
            ]
        );
    }
}
