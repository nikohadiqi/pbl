<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\TimPBL;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnggotaTimPbl extends Model
{
    use HasFactory;

    protected $table = 'anggota_tim_pbl';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_tim',
        'nim',
    ];

    public function tim()
    {
        return $this->belongsTo(TimPBL::class, 'kode_tim', 'kode_tim');
    }

    public function mahasiswaFK()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
      public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
