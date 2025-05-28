<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimPBL extends Model
{
    use HasFactory;

    protected $table = 'tim_pbl';
    protected $primaryKey = 'kode_tim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_tim',
        'kelas',
        'kelompok',
        'manpro',
        'periode',
        'status',
        'alasan_reject'
    ];

    public function anggota(): HasMany
    {
        return $this->hasMany(AnggotaTimPbl::class, 'kode_tim', 'kode_tim');
    }

    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'kode_tim', 'kode_tim');
    }

    public function rencanaProyek()
    {
        return $this->hasOne(RencanaProyek::class, 'kode_tim', 'kode_tim');
    }

    public function manproFK()
    {
        return $this->belongsTo(Dosen::class, 'manpro', 'nip');
    }

    public function periodeFK()
    {
        return $this->belongsTo(PeriodePBL::class, 'periode', 'id');
    }

    // Total Progres Logbook
    public function getProgressPercentAttribute()
    {
        // Ambil semua logbook progress untuk tim ini, asumsikan progress disimpan dalam string persen "60%"
        $progressValues = $this->logbooks()->pluck('progress')->filter();

        if ($progressValues->isEmpty()) {
            return 0;
        }

        // Asumsi progress disimpan sebagai angka string, misal "60"
        $total = 0;
        foreach ($progressValues as $progress) {
            // bersihkan jika ada %, dan cast ke int
            $num = (int) rtrim($progress, '% ');
            $total += $num;
        }
        return round($total);
    }
}
