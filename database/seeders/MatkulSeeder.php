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
            'kode' => 'RPL501',
            'matakuliah' => 'Proyek Aplikasi Lanjut',
            'program_studi' => 'Teknologi Rekayasa Perangkat Lunak',
        ]);
    }
}
