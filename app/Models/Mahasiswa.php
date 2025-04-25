<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan plural
    protected $table = 'mahasiswa';

    protected $primaryKey = 'nim'; // <- tambahkan ini
    public $incrementing = false;  // <- tambahkan ini
    protected $keyType = 'string'; // <- jika nim berupa string
    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'nim',
        'nama',
        'kelas',
    ];
}
