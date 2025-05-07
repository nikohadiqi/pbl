<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class regMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'tim_pbl'; // Nama tabel yang digunakan

    protected $primaryKey = 'kode_tim'; // Primary key

    protected $fillable = [
        'kode_tim', 'kelas', 'kelompok'
    ];

    // Relasi: Tim memiliki banyak anggota
    public function anggotaTim()
    {
        return $this->hasMany(AnggotaTimPbl::class, 'kode_tim', 'kode_tim');
    }

    public function akunMahasiswa(): HasMany
    {
        return $this->hasMany(AkunMahasiswa::class, 'kode_tim', 'kode_tim');
    }
}
