<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapanPelaksanaanProyek extends Model
{
    use HasFactory;

    protected $table = 'tahapan_pelaksanaan_proyeks';

    protected $fillable = [
        'periode_id',
        'tahapan',
        'score'
    ];

    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'tahapan_id');
    }

    public function periodeFK()
    {
        return $this->belongsTo(PeriodePBL::class, 'periode_id', 'id');
    }

}
