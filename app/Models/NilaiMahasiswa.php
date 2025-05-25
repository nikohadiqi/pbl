<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'nilai_mahasiswa'; // nama tabel sesuai migration

    protected $primaryKey = 'id';

    protected $fillable = [
        'nim', // relasi mahasiswa
        'pengampu_id', // relasi dosen pengampu
        'critical_thinking', // nilai manpro mulai sini // bobot 5%
        'kolaborasi', // bobot 5%
        'kreativitas', // bobot 5%
        'komunikasi', // bobot 5%
        'fleksibilitas', // bobot 5%
        'kepemimpinan', // bobot 5%
        'produktifitas', // bobot 10%
        'social_skill', // nilai manpro sampai sini // bobot 5%
        'konten_presentasi', // nilai dosen mk mulai sini // bobot 2%
        'tampilan_visual_presentasi', // bobot 2%
        'kosakata', // bobot 2%
        'tanya_jawab', // bobot 2%
        'mata_gerak_tubuh', // bobot 2%
        'penulisan_laporan', // bobot 3%
        'pilihan_kata', // bobot 2%
        'konten_laporan', // bobot 2%
        'sikap_kerja', // bobot 8%
        'proses', // bobot 15%
        'kualitas', // nilai dosen mk sampai sini // bobot 15%
        'total_nilai',
        'angka_nilai',
        'huruf_nilai',
        'nilai_aspek_json',
        'dosen_id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function pengampu()
    {
        return $this->belongsTo(Pengampu::class, 'pengampu_id', 'id');
    }
}
