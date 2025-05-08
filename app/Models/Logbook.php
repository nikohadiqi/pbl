<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $table = 'logbook';

    protected $fillable = [
        'aktivitas',
        'hasil',
        'foto_kegiatan',
        'kontribusi',
        'progress',
        'kode_tim',
        'nim'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(AkunMahasiswa::class, 'nim', 'nim');
    }

   // Relasi dengan tim_pbl
   public function timPbl()
   {
       return $this->belongsTo(TimPbl::class, 'kode_tim', 'kode_tim');
   }
}
