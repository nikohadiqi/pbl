<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estimasi extends Model
{
    use HasFactory;
    protected $table = 'estimasi';

    protected $fillable = [
        'fase', 'uraian_pekerjaan', 'estimasi_waktu', 'catatan'
    ];
}
