<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan plural
    protected $table = 'dosen';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'nip',
        'nama',
    ];
}
