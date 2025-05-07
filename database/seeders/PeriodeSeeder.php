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
            'semester' => '4',
            'tahun' => '2025',
        ]);

        PeriodePBL::create([
            'semester' => '5',
            'tahun' => '2025',
        ]);
    }
}
