<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dosen::create([
            'nip' => '198403052021212004',
            'nama' => 'Dianni Yusuf, S.Kom., M.Kom.',
            'no_telp' => '082328333399',
            'email' => 'dianniyusuf@poliwangi.ac.id',
            'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
            'jurusan' => 'Bisnis dan Informatika',
            'jenis_kelamin' => 'P',
            'status_dosen' => 'Aktif',
        ]);

        Dosen::create([
            'nip' => '199202272020122019',
            'nama' => 'Ruth Ema Febrita, S.Pd., M.Kom.',
            'no_telp' => '085259082627',
            'email' => 'RuthEmaFebrita@poliwangi.ac.id',
            'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
            'jurusan' => 'Bisnis dan Informatika',
            'jenis_kelamin' => 'P',
            'status_dosen' => 'Aktif',
        ]);
    }
}
