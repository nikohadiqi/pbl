<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapanPelaksanaanProyek extends Model
{
    use HasFactory;

    protected $table = 'tahapan_pelaksanaan_proyek';
    protected $fillable = ['semester_id', 'tahapan', 'score'];

    // Relasi ke PeriodePBL (berdasarkan semester_id)
    public function periodePBL()
    {
        return $this->belongsTo(PeriodePBL::class, 'semester_id', 'id');
    }
}
