<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tantangan extends Model
{
    use HasFactory;

    protected $table = 'tantangan';

    protected $fillable = [
        'timpbl_id',
        'mahasiswa_id',
        'proses',
        'tantangan',
        'level',
        'rencana_tindakan',
        'catatan'
    ];

    public function timPbl()
    {
        return $this->belongsTo(TimPbl::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
