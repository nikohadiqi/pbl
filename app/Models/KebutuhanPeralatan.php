<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanPeralatan extends Model
{
    use HasFactory;
    protected $table = 'kebutuhan_peralatan';

    protected $fillable = [
              'kode_tim','nomor', 'fase', 'peralatan', 'bahan'
    ];
    // Relasi dengan tim_pbl
   public function timPbl()
   {
       return $this->belongsTo(TimPBL::class, 'kode_tim', 'kode_tim');
   }
}
