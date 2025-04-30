<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaProyek extends Model
{
    use HasFactory;

    protected $table = 'rencana_proyek';

    protected $primaryKey = 'id_proyek';
    public $incrementing = false; // Karena id_tim bukan auto-increment
    protected $keyType = 'string'; // Karena id_tim bertipe string

    protected $fillable = [
        'id_proyek',
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
        'tahapan_pelaksanaan',
        'kebutuhan_peralatan',
        'tantangan',
        'estimasi',
        'biaya_proyek',
        'tim_proyek',
    ];
}
