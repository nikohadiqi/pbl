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
        'nim',
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
         'total_nilai',              // tambahkan
        'angka_nilai',              // tambahkan
        'huruf_nilai',              // tambahkan
        'nilai_aspek_json',         // tambahkan
        'dosen_id',          
    ];

    // Jika kamu ingin mendefinisikan relasi ke model DataMahasiswa
    public function dataMahasiswa()
    {
        return $this->belongsTo(DataMahasiswa::class, 'nim', 'nim');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function pengampu()
    {
        return $this->belongsTo(Pengampu::class, 'pengampu_id');
    }
}