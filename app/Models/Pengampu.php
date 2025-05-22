<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengampu extends Model
{
    use HasFactory;

    protected $table = 'pengampu';

    protected $fillable = [
        'kelas_id',
        'dosen_id',
        'status',
        'matkul_id',
        'periode_id'
    ];

    /**
     * Relasi tabel
     */
    public function kelasFk()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kelas');
    }

    public function dosenFk()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'nip');
    }

    public function matkulFK()
    {
        return $this->belongsTo(MataKuliah::class, 'matkul_id', 'id');
    }

    public function periodeFK()
    {
        return $this->belongsTo(PeriodePBL::class, 'periode_id', 'id');
    }

    public function nilaiMahasiswa()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'pengampu_id');
    }
}
