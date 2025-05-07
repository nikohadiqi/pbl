<?php

namespace App\Imports;

use App\Models\Dosen;
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
        return Dosen::updateOrCreate(
            ['nip' => $row['nip']], // Mencari berdasarkan NIP
            [
                'nama'          => $row['nama'],
                'no_telp'       => $row['no_telp'],
                'email'         => $row['email'],
                'prodi'         => $row['prodi'],
                'jurusan'       => $row['jurusan'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'status_dosen'  => $row['status_dosen'],
            ]
        );
    }
}
