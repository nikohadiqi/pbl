<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah';

    protected $fillable = [
        'program_studi',
        'kode',
        'matakuliah',
        'sks',
        'id_feeder',
        'periode_id',
    ];

    // Relasi Periode
    public function periodeFK()
    {
        return $this->belongsTo(PeriodePBL::class, 'periode_id');
    }
}
