<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tantangan extends Model
{
    use HasFactory;
    protected $table = 'tantangan';

    protected $fillable = [
        'nomor', 'proses', 'isu', 
        'level_resiko', 'catatan'
    ];
}
