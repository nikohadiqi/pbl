<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaProyek extends Model
{
    use HasFactory;

    protected $table = 'rencana_proyek';


    protected $fillable = [
        'id_tim',
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
public function timpbl()
{
    return $this->belongsTo(TimPBL::class, 'id_tim', 'id_tim');
}
}
