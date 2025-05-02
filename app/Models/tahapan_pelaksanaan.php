<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapanPelaksanaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'minggu', 'tahapan', 'pic', 'keterangan'
    ];
}
