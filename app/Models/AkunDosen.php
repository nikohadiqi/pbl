<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunDosen extends Model
{
    use HasFactory;
    protected $table = 'akun_dosen';
    protected $fillable = ['role', 'nip', 'password'];
}
