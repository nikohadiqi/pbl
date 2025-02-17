<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodePBL extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan plural
    protected $table = 'periodepbl';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'semester',
        'tahun',
    ];
}
