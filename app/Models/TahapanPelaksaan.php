<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapanPelaksaan extends Model
{
    use HasFactory;

    protected $table = 'tahapan_pelaksaan';

    protected $fillable = [
        'timpbl_id',
        'minggu',
        'tahapan',
        'pic',
        'keterangan',
    ];
}
