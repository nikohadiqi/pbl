<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimPBL extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan plural
    protected $table = 'timpbl';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'periode_pbl',
        'kelas',
        'code_tim',
        'ketua_tim',
        'anggota_tim', // Disimpan dalam format JSON
    ];

    // Konversi anggota_tim dari JSON ke array otomatis
    protected $casts = [
        'anggota_tim' => 'array',
    ];

    /**
     * Relasi ke PeriodePBL
     */
    public function periodePBL()
    {
        return $this->belongsTo(PeriodePBL::class, 'periode_pbl');
    }

    /**
     * Relasi ke Mahasiswa untuk ketua_tim
     */
    public function ketuaTim()
    {
        return $this->belongsTo(Mahasiswa::class, 'ketua_tim');
    }

    /**
     * Ambil data mahasiswa berdasarkan ID yang ada di anggota_tim (JSON)
     */
    public function getAnggotaTim()
    {
        return Mahasiswa::whereIn('id', $this->anggota_tim)->get();
    }
}
