<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $table = 'logbook';

    protected $fillable = [
        'timpbl_id',
        'mahasiswa_id',
        'aktivitas',
        'hasil',
        'foto_kegiatan',
        'anggota1',
        'anggota2',
        'anggota3',
        'anggota4',
        'anggota5'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function timPbl()
    {
        return $this->belongsTo(TimPbl::class, 'timpbl_id');
    }
}
