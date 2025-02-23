<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimProyek extends Model
{
    use HasFactory;

    protected $table = 'tim_proyek';

    protected $fillable = [
        'timpbl_id',
        'mahasiswa_id',
        'nama',
        'nim',
        'program_studi'
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
