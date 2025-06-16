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
        'hasil',
        'link_youtube',
        'laporan_pdf',
        'updated_by'
    ];

    // Relasi ke TimPbl
    public function timPbl()
    {
        return $this->belongsTo(TimPBL::class, 'kode_tim', 'kode_tim');
    }
}
