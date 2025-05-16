<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan plural
    protected $table = 'data_dosen';

    protected $primaryKey = 'nip'; // <- tambahkan ini
    public $incrementing = false;  // <- tambahkan ini
    protected $keyType = 'string'; // <- jika nim berupa string
    // Tentukan kolom yang dapat diisi

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'nip',
        'nama',
        'no_telp',
        'email',
        'prodi',
        'jurusan',
        'jenis_kelamin',
        'status_dosen',
    ];

    public function pengampuFK()
    {
        return $this->hasMany(Pengampu::class, 'dosen_id', 'nip');
    }
}
