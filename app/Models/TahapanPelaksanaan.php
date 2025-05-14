<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapanPelaksanaan extends Model
{
    use HasFactory;
    protected $table = 'tahapan_pelaksanaan';

    protected $fillable = [ 'kode_tim','minggu', 'tahapan', 'pic', 'keterangan'
    ];
    // Relasi dengan tim_pbl
   public function timPbl()
   {
       return $this->belongsTo(TimPbl::class, 'kode_tim', 'kode_tim');
   }
}
