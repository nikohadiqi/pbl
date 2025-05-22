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
        return true; // Ubah jika pakai policy
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
                function ($attribute, $value, $fail) {
                    $timAnggota = Anggota_Tim_Pbl::where('nim', $value)->first();
                    if (!$timAnggota) return;

                    $tim = regMahasiswa::where('kode_tim', $timAnggota->kode_tim)->first();
                    if (!$tim) return;

                    $periode = PeriodePBL::find($tim->periode);
                    if ($tim->status !== 'rejected' && $periode && $periode->status !== 'Selesai') {
                        $fail("Mahasiswa dengan NIM $value sudah terdaftar di tim aktif pada periode berjalan.");
                    }
                }
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
            $kode_tim = strtoupper($this->kelas) . $this->kelompok;

            $exists = regMahasiswa::where('kode_tim', $kode_tim)
                ->where('status', 'approved')
                ->exists();

            if ($exists) {
                $validator->errors()->add('kelompok', 'Tim ini sudah disetujui sebelumnya dan tidak bisa didaftarkan ulang.');
            }
        });
    }
}
