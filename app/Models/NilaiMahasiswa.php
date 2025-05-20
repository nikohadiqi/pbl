<?php

// app/Models/NilaiMahasiswa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'nilai_mahasiswa';

    protected $fillable = [
        'nim',
        'rubrik_id',
        'pengampu_id',
        'score',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function rubrik()
    {
        return $this->belongsTo(RubrikPenilaian::class, 'rubrik_id');
    }

    public function pengampu()
    {
        return $this->belongsTo(Pengampu::class, 'pengampu_id');
    }
}