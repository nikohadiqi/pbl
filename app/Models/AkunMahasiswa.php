<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class AkunMahasiswa extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'akun_mahasiswa'; // atau nama tabel kamu

    protected $fillable = [
       'kode_tim',
        'nim',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];
    public function role()
    {
        return $this->belongsTo(RoleMiddleware::class);
    }
}
