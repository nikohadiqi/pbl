<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AkunMahasiswa;
use App\Models\Anggota_Tim_Pbl;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\PeriodePBL;
use App\Models\regMahasiswa;
use App\Models\TimPbl;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaRegisterController extends Controller
{
    public function showRegisterForm()
    {
        $kelas = Kelas::all();
        $periode = PeriodePBL::where('status', 'Aktif')->get();
        // menampilkan tim yang sedang divalidasi
        $timPendingRejected = TimPbl::whereIn('status', ['pending', 'rejected'])
                            ->select('kelas', 'kelompok', 'status')
                            ->get();

        return view('auth.register', compact('kelas', 'periode', 'timPendingRejected'));
    }

    public function register(Request $request)
    {
        // Validasi inputan agar sesuai
        $request->validate([
            'kelas' => 'required|string',
            'kelompok' => 'required|integer',
            'manpro' => 'required|string|exists:pengampu,dosen_id',
            'periode' => 'required|string',
            'anggota' => 'required|array|min:1',
            'anggota.*' => [
                'string',
                'distinct',
                'exists:data_mahasiswa,nim',
                Rule::unique('anggota_tim_pbl', 'nim')
                    ->where(function ($query) {
                        $query->whereNotIn('kode_tim', function ($sub) {
                            $sub->select('kode_tim')
                                ->from('tim_pbl')
                                ->where('status', 'rejected');
                        });
                    })
            ],
        ], [
            'anggota.*.unique' => 'Mahasiswa dengan NIM :input sudah terdaftar di tim lain.',
            'anggota.*.exists' => 'Mahasiswa dengan NIM :input tidak ditemukan.',
            'anggota.*.distinct' => 'Mahasiswa dengan NIM :input duplikat di daftar anggota.',
        ]);

        $kode_tim = strtoupper($request->kelas) . $request->kelompok;

        // ❗ Cek apakah tim sudah disetujui sebelumnya
        $timApproved = regMahasiswa::where('kode_tim', $kode_tim)
            ->where('status', 'approved')
            ->exists();

        if ($timApproved) {
            return back()
                ->withErrors(['kelompok' => 'Tim dengan kelas dan kelompok ini sudah disetujui dan tidak bisa didaftarkan ulang.'])
                ->withInput();
        }

        // Cari data tim dulu
        $tim = regMahasiswa::where('kode_tim', $kode_tim)->first();

        if ($tim) {
            if ($tim->status === 'rejected') {
                // Ubah status ke pending dan update data lain
                $tim->status = 'pending';
                $tim->kelas = $request->kelas;
                $tim->kelompok = $request->kelompok;
                $tim->manpro = $request->manpro;
                $tim->periode = $request->periode;
                $tim->save();

                // Hapus anggota lama dari tim ini
                Anggota_Tim_Pbl::where('kode_tim', $kode_tim)->delete();

                // Hapus akun mahasiswa yang terkait dengan kode_tim lama
                AkunMahasiswa::where('kode_tim', $kode_tim)->delete();
            }
            // Kalau status bukan rejected, bisa update data lain
        } else {
            // Jika belum ada, buat baru
            $tim = regMahasiswa::create([
                'kode_tim' => $kode_tim,
                'kelas' => $request->kelas,
                'kelompok' => $request->kelompok,
                'manpro' => $request->manpro,
                'periode' => $request->periode,
                'status' => 'pending',
            ]);
        }

        // Ambil Nama Manpro di Data Dosen
        $timModel = \App\Models\regMahasiswa::with('manproFK')->where('kode_tim', $kode_tim)->first();
        $namaManpro = $timModel->manproFK->nama ?? '-';

        // Buat akun mahasiswa jika belum ada dan tambahkan anggota baru
        foreach ($request->anggota as $nim) {
            // Buat akun mahasiswa jika belum ada
            AkunMahasiswa::firstOrCreate([
                'nim' => $nim,
            ], [
                'kode_tim' => $kode_tim,
                'password' => Hash::make($nim),
                'role' => 'mahasiswa',
            ]);

            // Tambahkan ke anggota_tim_pbl
            Anggota_Tim_Pbl::create([
                'kode_tim' => $kode_tim,
                'nim' => $nim,
            ]);
        }

        $periode = PeriodePBL::find($request->periode);

        // Ambil nama mahasiswa dari tabel Mahasiswa
        $anggota = collect($request->anggota)->map(function ($nim) {
            $nama = Mahasiswa::where('nim', $nim)->value('nama');
            return [
                'nim' => $nim,
                'nama' => $nama ?? '-',
            ];
        })->toArray();

        $timData = [
            'kelas' => $request->kelas,
            'kelompok' => $request->kelompok,
            'periode' => [
                'semester' => $periode->semester,
                'tahun' => $periode->tahun,
            ],
            'manpro' => $namaManpro,
            'anggota' => $anggota,
        ];

        session()->flash('tim', $timData);
        return redirect()->route('register.tunggu-validasi');
    }
}
