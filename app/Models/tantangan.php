<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tantangan extends Model
{
    use HasFactory;
    protected $table = 'tantangan';

    protected $fillable = [
              'kode_tim','nomor', 'proses', 'isu',
        'level_resiko', 'catatan'
    ];
    // Relasi dengan tim_pbl
   public function timPbl()
   {
       return $this->belongsTo(TimPBL::class, 'kode_tim', 'kode_tim');
   }
}
