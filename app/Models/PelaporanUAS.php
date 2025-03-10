<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaporanUAS extends Model
{
    use HasFactory;

    protected $table = 'pelaporan_uas';

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
