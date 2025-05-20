<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'nilai_mahasiswa';

    protected $fillable = [
        'nim',
        'pengampu_id',
        'critical_thinking',
        'kolaborasi',
        'kreativitas',
        'komunikasi',
        'fleksibilitas',
        'kepemimpinan',
        'produktifitas',
        'social_skill',
        'konten',
        'tampilan_visual_presentasi',
        'kosakata',
        'tanya_jawab',
        'mata_gerak_tubuh',
        'penulisan_laporan',
        'pilihan_kata',
        'konten_2',
        'sikap_kerja',
        'proses',
        'kualitas',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function pengampu()
    {
        return $this->belongsTo(Pengampu::class, 'pengampu_id');
    }
}