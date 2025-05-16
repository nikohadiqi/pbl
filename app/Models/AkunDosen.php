<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AkunDosen extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'akun_dosen';

    protected $fillable = ['role', 'nim', 'password'];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public $timestamps = true;

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'nip', 'nim');
    }
}
