<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estimasi extends Model
{
    use HasFactory;
    protected $table = 'estimasi';

    protected $fillable = [
        'kode_tim', 'fase', 'uraian_pekerjaan', 'estimasi_waktu', 'catatan'
    ];
    // Relasi dengan tim_pbl
   public function timPbl()
   {
       return $this->belongsTo(TimPbl::class, 'kode_tim', 'kode_tim');
   }
}
