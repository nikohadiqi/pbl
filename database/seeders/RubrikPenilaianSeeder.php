<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RubrikPenilaian;

class RubrikPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        $rubrik = [
            // Rubrik Penilaian Default
            // Manpro 45 % => Aspek Softskill (8 aspek)
            ['aspek_penilaian' => 'Critical Thinking', 'jenis' => 'softskill', 'bobot' => 5],
            ['aspek_penilaian' => 'Kolaborasi', 'jenis' => 'softskill', 'bobot' => 5],
            ['aspek_penilaian' => 'Kreativitas dan Inovasi', 'jenis' => 'softskill', 'bobot' => 5],
            ['aspek_penilaian' => 'Komunikasi', 'jenis' => 'softskill', 'bobot' => 5],
            ['aspek_penilaian' => 'Fleksibilitas', 'jenis' => 'softskill', 'bobot' => 5],
            ['aspek_penilaian' => 'Kepemimpinan', 'jenis' => 'softskill', 'bobot' => 5],
            ['aspek_penilaian' => 'Produktivitas', 'jenis' => 'softskill', 'bobot' => 10],
            ['aspek_penilaian' => ' Social Skill', 'jenis' => 'softskill', 'bobot' => 5],

            // Dosen MK 55% => Aspek Akademik (11 aspek)
            ['aspek_penilaian' => ' Konten Presentasi', 'jenis' => 'akademik', 'bobot' => 2],
            ['aspek_penilaian' => 'Tampilan Visual Presentasi', 'jenis' => 'akademik', 'bobot' => 2],
            ['aspek_penilaian' => ' Pemilihan Kosakata dalam Penyampaian Materi', 'jenis' => 'akademik', 'bobot' => 2],
            ['aspek_penilaian' => 'Tanya Jawab dengan Peserta', 'jenis' => 'akademik', 'bobot' => 2],
            ['aspek_penilaian' => 'Mata dan Gerak Tubuh', 'jenis' => 'akademik', 'bobot' => 2],
            ['aspek_penilaian' => 'Penulisan Laporan', 'jenis' => 'akademik', 'bobot' => 3],
            ['aspek_penilaian' => 'Pilihan Kata yang Digunakan', 'jenis' => 'akademik', 'bobot' => 2],
            ['aspek_penilaian' => 'Konten Laporan', 'jenis' => 'akademik', 'bobot' => 2],
            ['aspek_penilaian' => ' Sikap Kerja', 'jenis' => 'akademik', 'bobot' => 8],
            ['aspek_penilaian' => 'Proses Kerja', 'jenis' => 'akademik', 'bobot' => 15],
            ['aspek_penilaian' => 'Kualitas Kerja', 'jenis' => 'akademik', 'bobot' => 15],
        ];

        RubrikPenilaian::truncate(); // Kosongkan dulu
        RubrikPenilaian::insert($rubrik);
    }
}
