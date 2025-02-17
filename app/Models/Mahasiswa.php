<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan plural
    protected $table = 'mahasiswa';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'id_tahun',
        'nim',
        'nama',
    ];
}
