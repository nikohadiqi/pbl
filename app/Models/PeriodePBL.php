<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodePBL extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan plural
    protected $table = 'periodepbl';

    // mengubah date ke string
    protected $casts = [
        'closed_at' => 'datetime',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'kategori_semester',
        'tahun',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'closed_at',
        'closed_by',
    ];

    public function penutup()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function matakuliahFK()
    {
        return $this->hasMany(MataKuliah::class, 'periode_id');
    }
}
