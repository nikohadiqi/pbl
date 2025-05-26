<?php

namespace App\Exports;

use App\Models\NilaiMahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;

class NilaiMahasiswaExport implements FromCollection, WithCustomStartCell, WithEvents
{
    protected $selectedKelas;

    public function __construct($selectedKelas)
    {
        $this->selectedKelas = $selectedKelas;
    }

    public function collection()
    {
        return NilaiMahasiswa::with('mahasiswa')
            ->whereHas('mahasiswa', function($q) {
                $q->where('kelas', $this->selectedKelas); // pakai $this->selectedKelas
            })
            ->get()
        ->map(function($nilai) {
            return [
                'nim' => (string) $nilai->nim,
                'nama' => is_array($nilai->mahasiswa->nama) ? json_encode($nilai->mahasiswa->nama) : (string) $nilai->mahasiswa->nama,
                'critical_thinking' => (string) $nilai->critical_thinking,
                'kolaborasi' => (string) $nilai->kolaborasi,
                'kreativitas' => (string) $nilai->kreativitas,
                'komunikasi' => (string) $nilai->komunikasi,
                'fleksibilitas' => (string) $nilai->fleksibilitas,
                'kepemimpinan' => (string) $nilai->kepemimpinan,
                'produktifitas' => (string) $nilai->produktifitas,
                'social_skill' => (string) $nilai->social_skill,
                'konten_presentasi' => (string) $nilai->konten_presentasi,
                'tampilan_visual_presentasi' => (string) $nilai->tampilan_visual_presentasi,
                'kosakata' => (string) $nilai->kosakata,
                'tanya_jawab' => (string) $nilai->tanya_jawab,
                'mata_gerak_tubuh' => (string) $nilai->mata_gerak_tubuh,
                'penulisan_laporan' => (string) $nilai->penulisan_laporan,
                'pilihan_kata' => (string) $nilai->pilihan_kata,
                'konten_laporan' => (string) $nilai->konten_laporan,
                'sikap_kerja' => (string) $nilai->sikap_kerja,
                'proses' => (string) $nilai->proses,
                'kualitas' => (string) $nilai->kualitas,

                // Contoh, konversi nilai_aspek_json ke string (JSON encode)
                'nilai_aspek_json' => is_array($nilai->nilai_aspek_json) ? json_encode($nilai->nilai_aspek_json) : (string) $nilai->nilai_aspek_json,

                // Kolom lain jika perlu ditambahkan...
            ];
        });
}

public function startCell(): string
    {
        return 'A4'; // sesuaikan dengan posisi mulai isi data di template
    }

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function(BeforeWriting $event) {
                $event->writer->setUseDiskCaching(true);
                // Load template
                $templatePath = storage_path('app/templates/rubrik_penilaian_pbl.xls');
                // Perlu cara yang tepat untuk load template dengan Maatwebsite Excel,
                // biasanya menggunakan WithCustomStartCell atau WithEvents bisa lebih rumit
            },
        ];
    }
}
