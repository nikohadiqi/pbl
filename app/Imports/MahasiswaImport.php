<?php

namespace App\Imports;

use App\Models\Mahasiswa;
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
        return Mahasiswa::updateOrCreate(
            ['nim' => $row['nim']], // Mencari berdasarkan NIM
            [
                'nama'          => $row['nama'],
                'program_studi' => $row['program_studi'],
                'dosen_wali'    => $row['dosen_wali'],
                'status'        => $row['status'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'kelas'         => $row['kelas'],
                'angkatan'      => $row['angkatan'],
            ]
        );
    }
}
