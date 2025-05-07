<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mahasiswa::create([
            'nim' => '362355401085',
            'nama' => 'Rio Adjie',
            'program_studi' => 'Teknologi Rekayasa Perangkat Lunak',
            'dosen_wali' => 'Diani Yusuf',
            'status' => 'Aktif',
            'jenis_kelamin' => 'L',
            'kelas' => '2C',
            'angkatan' => '2023',
        ]);

        Mahasiswa::create([
            'nim' => '362355401057',
            'nama' => 'Achmad Nico',
            'program_studi' => 'Teknologi Rekayasa Perangkat Lunak',
            'dosen_wali' => 'Ruth Ema',
            'status' => 'Aktif',
            'jenis_kelamin' => 'L',
            'kelas' => '2B',
            'angkatan' => '2023',
        ]);
    }
}
