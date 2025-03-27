<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimPBL extends Model
{
    use HasFactory;

    protected $table = 'timpbl';

    protected $fillable = [
        'id_tim',
        'code_tim',
        'ketua_tim',
    ];

    /**
     * Relasi ke tabel Mahasiswa untuk Ketua Tim
     */
    public function ketua()
    {
        return $this->belongsTo(Mahasiswa::class, 'ketua_tim', 'id');
    }
}
