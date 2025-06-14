<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MataKuliah::create([
            'kode' => 'RPL04001',
            'matakuliah' => 'Proyek Aplikasi Lanjut',
            'program_studi' => 'Teknologi Rekayasa Perangkat Lunak',
            'sks' => '2',
            'semester' => 3,
            'periode_id' => 1
        ]);

        MataKuliah::create([
            'kode' => 'RPL04002',
            'matakuliah' => 'Desain Pengalaman Pengguna',
            'program_studi' => 'Teknologi Rekayasa Perangkat Lunak',
            'sks' => '2',
            'semester' => 3,
            'periode_id' => 1
        ]);

        MataKuliah::create([
            'kode' => 'RPL04003',
            'matakuliah' => 'Keamanan Perangkat Lunak',
            'program_studi' => 'Teknologi Rekayasa Perangkat Lunak',
            'sks' => '2',
            'semester' => 3,
            'periode_id' => 1
        ]);
    }
}
