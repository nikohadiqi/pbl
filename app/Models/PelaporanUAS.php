<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaporanUAS extends Model
{
    use HasFactory;

    protected $table = 'pelaporan_uas';

    protected $fillable = [
        'kode_tim',
        'keterangan',
        'link_drive',
        'link_youtube',
        'laporan_pdf'
    ];

    // Relasi ke TimPbl
    public function timPbl()
    {
        return $this->belongsTo(TimPbl::class, 'kode_tim', 'kode_tim');
    }
}
