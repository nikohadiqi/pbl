<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaProyek extends Model
{
    use HasFactory;

    protected $table = 'rencana_proyek';

    protected $fillable = [
        'timpbl_id',
        'mahasiswa_id',
        'judul_proyek',
        'pengusul_proyek',
        'manajer_proyek',
        'luaran',
        'sponsor',
        'biaya',
        'klien',
        'waktu',
        'ruang_lingkup',
        'rancangan_sistem',
    ];
}
