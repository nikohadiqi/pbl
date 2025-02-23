<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapaianPembelajaran extends Model
{
    use HasFactory;

    protected $table = 'capaian_pembelajaran';

    protected $fillable = [
        'timpbl_id',
        'mahasiswa_id',
        'mata_kuliah',
        'capaian',
        'tujuan'
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
