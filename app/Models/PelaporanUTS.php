<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaporanUTS extends Model
{
    use HasFactory;

    protected $table = 'pelaporan_uts';

    protected $fillable = [
        'timpbl_id',
        'mahasiswa_id',
        'keterangan',
        'link_drive',
        'link_youtube',
        'laporan_pdf'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function timPbl()
    {
        return $this->belongsTo(TimPbl::class, 'timpbl_id');
    }
}
