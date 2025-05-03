<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::create([
            'kelas' => '2A',
        ]);

        Kelas::create([
            'kelas' => '2B',
        ]);

        Kelas::create([
            'kelas' => '2C',
        ]);

        Kelas::create([
            'kelas' => '2D',
        ]);

        Kelas::create([
            'kelas' => '2E',
        ]);

        Kelas::create([
            'kelas' => '2F',
        ]);
    }
}
