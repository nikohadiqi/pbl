<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class regMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'tim_pbl'; // Nama tabel yang digunakan

    protected $primaryKey = 'kode_tim'; // Primary key

    protected $fillable = [
        'kode_tim', 'kelas', 'kelompok', 'manpro', 'periode'
    ];

    // Relasi: Tim memiliki banyak anggota
    public function anggotaTim()
    {
        return $this->hasMany(Anggota_Tim_Pbl::class, 'kode_tim', 'kode_tim');
    }

    public function akunMahasiswa(): HasMany
    {
        return $this->hasMany(AkunMahasiswa::class, 'kode_tim', 'kode_tim');
    }

    public function manproFK()
    {
        return $this->belongsTo(Dosen::class, 'manpro', 'nip');
    }
}
