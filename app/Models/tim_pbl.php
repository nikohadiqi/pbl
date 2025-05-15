<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimPbl extends Model
{
    use HasFactory;

    protected $table = 'tim_pbl';
    protected $primaryKey = 'kode_tim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_tim',
        'kelas',
        'kelompok',
        'manpro',
        'periode',
    ];

    public function anggota(): HasMany
    {
        return $this->hasMany(AnggotaTimPbl::class, 'kode_tim', 'kode_tim');
    }
    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'kode_tim', 'kode_tim');
    }

}
