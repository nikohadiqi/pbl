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
        'aspek_penilaian',
        'jenis',
        'bobot',
    ];

    public function nilaiMahasiswa()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'rubrik_id');
    }
}
