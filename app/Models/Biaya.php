<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
   use HasFactory;
    protected $table = 'biaya';

   protected $fillable = [
        'kode_tim', 'fase', 'uraian_pekerjaan', 'perkiraan_biaya', 'catatan'
    ];
    // Relasi dengan tim_pbl
   public function timPbl()
   {
       return $this->belongsTo(TimPbl::class, 'kode_tim', 'kode_tim');
   }
}
