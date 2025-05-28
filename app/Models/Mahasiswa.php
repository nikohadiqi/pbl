<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan plural
    protected $table = 'data_mahasiswa';

    protected $primaryKey = 'nim'; // <- tambahkan ini
    public $incrementing = false;  // <- tambahkan ini
    protected $keyType = 'string'; // <- jika nim berupa string
    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'nim',
        'nama',
        'program_studi',
        'dosen_wali',
        'status',
        'jenis_kelamin',
        'kelas',
        'angkatan',
    ];

    /**
     * Relasi ke tabel kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas', 'kelas');
    }

    public function tim_pbl()
    {
        return $this->hasMany(AnggotaTimPbl::class, 'nim', 'nim');
    }
     // Tambahkan relasi nilai mahasiswa
    public function nilaiMahasiswa()
    {
        return $this->hasMany(\App\Models\NilaiMahasiswa::class, 'nim', 'nim');
    }
}
