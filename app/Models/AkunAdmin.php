<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunAdmin extends Model
{
    use HasFactory;
    protected $table = 'akun_admin';
    protected $fillable = ['role', 'nip', 'password'];
}
