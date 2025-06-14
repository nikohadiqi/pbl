<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RubrikPenilaian;

class RubrikPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        $rubrik = [
            // Softskill (8 aspek)
            ['aspek_penilaian' => 'Kedisiplinan', 'jenis' => 'softskill', 'bobot' => 6],
            ['aspek_penilaian' => 'Kerjasama Tim', 'jenis' => 'softskill', 'bobot' => 6],
            ['aspek_penilaian' => 'Komunikasi', 'jenis' => 'softskill', 'bobot' => 6],
            ['aspek_penilaian' => 'Tanggung Jawab', 'jenis' => 'softskill', 'bobot' => 5],
            ['aspek_penilaian' => 'Etika dan Sikap Profesional', 'jenis' => 'softskill', 'bobot' => 5],
            ['aspek_penilaian' => 'Kreativitas dan Inovasi', 'jenis' => 'softskill', 'bobot' => 5],
            ['aspek_penilaian' => 'Inisiatif', 'jenis' => 'softskill', 'bobot' => 6],
            ['aspek_penilaian' => 'Manajemen Waktu', 'jenis' => 'softskill', 'bobot' => 6],

            // Akademik (11 aspek)
            ['aspek_penilaian' => 'Pemahaman Konsep', 'jenis' => 'akademik', 'bobot' => 5],
            ['aspek_penilaian' => 'Analisis Masalah', 'jenis' => 'akademik', 'bobot' => 5],
            ['aspek_penilaian' => 'Desain Solusi', 'jenis' => 'akademik', 'bobot' => 5],
            ['aspek_penilaian' => 'Implementasi Program', 'jenis' => 'akademik', 'bobot' => 5],
            ['aspek_penilaian' => 'Pengujian dan Debugging', 'jenis' => 'akademik', 'bobot' => 5],
            ['aspek_penilaian' => 'Dokumentasi Teknis', 'jenis' => 'akademik', 'bobot' => 5],
            ['aspek_penilaian' => 'Penggunaan Tools/Framework', 'jenis' => 'akademik', 'bobot' => 5],
            ['aspek_penilaian' => 'Standar Kode', 'jenis' => 'akademik', 'bobot' => 5],
            ['aspek_penilaian' => 'Penyampaian Presentasi', 'jenis' => 'akademik', 'bobot' => 5],
            ['aspek_penilaian' => 'Ketepatan Waktu Penyelesaian', 'jenis' => 'akademik', 'bobot' => 5],
            ['aspek_penilaian' => 'Penerapan Prinsip TRPL', 'jenis' => 'akademik', 'bobot' => 5],
        ];

        RubrikPenilaian::truncate(); // Kosongkan dulu
        RubrikPenilaian::insert($rubrik);
    }
}
