<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\TimPbl;

class Anggota_Tim_Pbl extends Model
{
    use HasFactory;

    protected $table = 'anggota_tim_pbl';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_tim',
        'nim',
        'manpro',
        'periode',
        'status' // Kolom status yang nullable
    ];

    public function tim()
    {
        return $this->belongsTo(TimPbl::class, 'kode_tim', 'kode_tim');
    }

    public function mahasiswaFK()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
