<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpp_sem5 extends Model
{
    use HasFactory;

    protected $table = 'tpp_sem5';

    protected $fillable = [
        'tahapan',
        'pic',
        'score'
    ];
}
