<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpp_sem4 extends Model
{
    use HasFactory;

    protected $table = 'tpp_sem4';

    protected $fillable = [
    'tahapan',
    'pic',
    'score'
];
public function logbooks()
{
    return $this->hasMany(Logbook::class, 'tahapan_id');
}
}
