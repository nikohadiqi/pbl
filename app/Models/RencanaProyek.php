<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaProyek extends Model
{
    use HasFactory;

    protected $table = 'rencana_proyek';

    public $incrementing = false; // Since id_proyek is string and nullable, no auto-increment

    protected $primaryKey = null; // No primary key defined in migration

    public $timestamps = false; // No timestamps columns in migration

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
        'minggu',
        'tahapan',
        'pic',
        'keterangan',
        'proses',
        'peralatan',
        'bahan',
        'tantangan',
        'level',
        'rencana_tindakan',
        'catatan',
        'uraian_pekerjaan',
        'perkiraan_biaya',
        'estimasi',
        'nama',
        'nim',
        'program_studi',
    ];
}
