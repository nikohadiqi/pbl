<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Anggota_Tim_Pbl;
use App\Models\regMahasiswa;
use App\Models\PeriodePBL;

class RegisterTimRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Sesuaikan jika perlu otorisasi tambahan
    }

    public function rules()
    {
        return [
            'kelas' => 'required|string',
            'kelompok' => 'required|integer',
            'manpro' => 'required|string|exists:pengampu,dosen_id',
            'periode' => 'required|string|exists:periodepbl,id',
            'anggota' => 'required|array|min:1',
            'anggota.*' => [
                'string',
                'distinct',
                'exists:data_mahasiswa,nim',
            ],
        ];
    }

    public function messages()
    {
        return [
            'anggota.*.distinct' => 'Mahasiswa dengan NIM :input duplikat di daftar anggota.',
            'anggota.*.exists' => 'Mahasiswa dengan NIM :input tidak ditemukan.',
            'anggota.*.string' => 'NIM harus berupa string.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $kelas = strtoupper($this->kelas);
            $kelompok = $this->kelompok;
            $kode_tim = $kelas . $kelompok;

            // 1. Cek jika tim dengan kode ini sudah approved
            $exists = regMahasiswa::where('kode_tim', $kode_tim)
                ->where('status', 'approved')
                ->exists();

            if ($exists) {
                $validator->errors()->add('kelompok', 'Tim ini sudah disetujui sebelumnya dan tidak bisa didaftarkan ulang.');
            }

            // 2. Validasi NIM hanya boleh tergabung di 1 tim per periode aktif (tidak 'rejected', dan periode belum selesai)
            $anggota = $this->anggota ?? [];
            if (empty($anggota)) return;

            // Ambil semua periode yang belum 'Selesai'
            $periodeAktif = PeriodePBL::where('status', '!=', 'Selesai')->pluck('id')->toArray();

            // Ambil kode_tim yang masih aktif di periode yang belum selesai dan bukan rejected
            $timAktif = regMahasiswa::whereIn('periode', $periodeAktif)
                ->where('status', '!=', 'rejected')
                ->pluck('kode_tim');

            // Cari semua NIM yang terdaftar di tim-tim tersebut
            $nimSudahTerdaftar = Anggota_Tim_Pbl::whereIn('kode_tim', $timAktif)->pluck('nim')->toArray();

            // Cek jika ada nim dari request yang bentrok
            $nimBentrok = array_intersect($anggota, $nimSudahTerdaftar);
            if (!empty($nimBentrok)) {
                $validator->errors()->add(
                    'anggota',
                    'NIM ' .implode(', ', $nimBentrok) .' sudah tergabung di tim lain pada periode aktif.'
                );
            }
        });
    }
}
