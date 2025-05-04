<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanPeralatan extends Model
{
    use HasFactory;
    protected $table = 'kebutuhan_peralatan';

    protected $fillable = [
        'nomor', 'fase', 'peralatan', 'bahan'
    ];
}