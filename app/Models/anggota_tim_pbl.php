<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anggota_Tim_Pbl extends Model
{
    use HasFactory;

    protected $table = 'anggota_tim_pbl';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_tim',
        'nim',
        'nama', // Nama anggota tim
        'status' // Kolom status yang nullable
    ];

    public function tim(): BelongsTo
    {
        return $this->belongsTo(TimPbl::class, 'kode_tim', 'kode_tim');
    }
}
