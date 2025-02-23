<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaProyek extends Model
{
    use HasFactory;

    protected $table = 'biaya_proyek';

    protected $fillable = [
        'timpbl_id',
        'mahasiswa_id',
        'proses',
        'uraian_pekerjaan',
        'perkiraan_biaya',
        'catatan'
    ];

    public function timPbl()
    {
        return $this->belongsTo(TimPbl::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
