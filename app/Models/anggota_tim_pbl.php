<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaTimPbl extends Model
{
    use HasFactory;

    protected $table = 'anggota_tim_pbl'; // Nama tabel yang digunakan

    protected $fillable = [
        'kode_tim', 'nim'
    ];

    // Relasi: Anggota milik tim
    public function tim()
    {
        return $this->belongsTo(TimPbl::class, 'kode_tim', 'kode_tim');
    }
}

