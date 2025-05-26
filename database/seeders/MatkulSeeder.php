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
            'kode' => 'RPL401',
            'matakuliah' => 'Proyek Aplikasi Lanjut',
            'program_studi' => 'Teknologi Rekayasa Perangkat Lunak',
            'sks' => '2',
        ]);

        MataKuliah::create([
            'kode' => 'RPL402',
            'matakuliah' => 'Desain Pengalaman Pengguna',
            'program_studi' => 'Teknologi Rekayasa Perangkat Lunak',
            'sks' => '2',
        ]);

        MataKuliah::create([
            'kode' => 'RPL403',
            'matakuliah' => 'Keamanan Perangkat Lunak',
            'program_studi' => 'Teknologi Rekayasa Perangkat Lunak',
            'sks' => '2',
        ]);
    }
}
