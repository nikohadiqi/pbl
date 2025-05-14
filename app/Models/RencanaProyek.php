<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaProyek extends Model
{
    use HasFactory;

    protected $table = 'rencana_proyek';


    protected $fillable = [
        'kode_tim',
        'judul_proyek',
        'pengusul_proyek',
        'manajer_proyek',
        'luaran',
        'sponsor',
        'biaya',
        'klien',
        'waktu',
        'ruang_lingkup',
        'rancangan_sistem',
        'tantangan',
        'estimasi',
        'biaya_proyek',
        'tim_proyek',
        'evaluasi'
    ];
    public function tahapanPelaksanaan()
{
    return $this->hasMany(TahapanPelaksanaan::class);
}

    public function kebutuhanPeralatan()
{
    return $this->hasMany(KebutuhanPeralatan::class);
}
    public function estimasi()
{
    return $this->hasMany(estimasi::class);
}

    public function tantangan()
{
    return $this->hasMany(tantangan::class);
}
// Relasi dengan tim_pbl
public function timPbl()
{
    return $this->belongsTo(TimPbl::class, 'kode_tim', 'kode_tim');
}
}
