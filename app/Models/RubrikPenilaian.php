<?php

// app/Models/RubrikPenilaian.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubrikPenilaian extends Model
{
    use HasFactory;

    protected $table = 'rubrik_penilaian';

    protected $fillable = [
        'metode_asesmen',
        'aspek_penilaian',
        'bobot'
    ];


    public function nilaiMahasiswa()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'rubrik_id');
    }
}
