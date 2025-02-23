<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanPeralatan extends Model
{
    use HasFactory;

    protected $table = 'kebutuhan_peralatan';

    protected $fillable = [
        'timpbl_id',
        'mahasiswa_id',
        'proses',
        'peralatan',
        'bahan'
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
