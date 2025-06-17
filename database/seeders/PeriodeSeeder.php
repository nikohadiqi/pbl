<?php

namespace Database\Seeders;

use App\Models\PeriodePBL;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PeriodePBL::create([
            'kategori_semester' => 'Ganjil',
            'tahun' => '2025',
            'tanggal_mulai' => '2025-01-01',
            'tanggal_selesai' => '2025-06-30',
            'status' => 'Aktif',
        ]);

        PeriodePBL::create([
            'kategori_semester' => 'Genap',
            'tahun' => '2025',
            'tanggal_mulai' => '2025-08-01',
            'tanggal_selesai' => '2025-12-30',
            'status' => 'Tidak Aktif',
        ]);
    }
}
