<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimPBL extends Model
{
    use HasFactory;

    protected $table = 'timpbl';

    // Atur Primary Key ke id_tim
    protected $primaryKey = 'id_tim';
    public $incrementing = false; // Karena id_tim bukan auto-increment
    protected $keyType = 'string'; // Karena id_tim bertipe string

    protected $fillable = [
        'id_tim',
        'ketua_tim',
        'periode_id',
        'manpro'
    ];

    /**
     * Relasi ke tabel Mahasiswa untuk Ketua Tim
     */
    public function ketua()
    {
        return $this->belongsTo(Mahasiswa::class, 'ketua_tim', 'nim');
    }

    // Relasi dengan periode
    public function periode()
    {
        return $this->belongsTo(PeriodePBL::class, 'periode_id', 'id');
    }

    // Relasi dengan dosen
    public function manajer_proyek()
    {
        return $this->belongsTo(Dosen::class, 'manpro', 'nip');
    }

    // Relasi User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
