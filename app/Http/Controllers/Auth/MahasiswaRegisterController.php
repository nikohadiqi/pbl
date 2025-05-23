<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTimRequest;
use App\Models\AkunMahasiswa;
use App\Models\Anggota_Tim_Pbl;
use App\Models\Mahasiswa;
use App\Models\PeriodePBL;
use App\Models\regMahasiswa;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaRegisterController extends Controller
{
    public function showRegisterForm()
    {
        $kelas = \App\Models\Kelas::all();
        $periode = PeriodePBL::where('status', 'Aktif')->get();

        $timPendingRejected = regMahasiswa::whereIn('status', ['pending', 'rejected'])
            ->select('kelas', 'kelompok', 'status')
            ->get();

        return view('auth.register', compact('kelas', 'periode', 'timPendingRejected'));
    }

    public function register(RegisterTimRequest $request)
    {
        $kode_tim = strtoupper($request->kelas) . $request->kelompok;

        // Cek tim yang sudah pernah dibuat (termasuk rejected)
        $tim = regMahasiswa::where('kode_tim', $kode_tim)->first();

        if ($tim) {
            if ($tim->status === 'rejected') {
                // Update status ke pending & update data lain
                $tim->update([
                    'kelas' => $request->kelas,
                    'kelompok' => $request->kelompok,
                    'manpro' => $request->manpro,
                    'periode' => $request->periode,
                    'status' => 'pending',
                ]);

                // Hapus anggota dan akun lama
                Anggota_Tim_Pbl::where('kode_tim', $kode_tim)->delete();
                AkunMahasiswa::where('kode_tim', $kode_tim)->delete();
            }
            // Jika status bukan rejected, tim sudah pasti approved atau pending,
            // dan validasi sudah cegah pendaftaran ulang
        } else {
            // Buat data tim baru
            $tim = regMahasiswa::create([
                'kode_tim' => $kode_tim,
                'kelas' => $request->kelas,
                'kelompok' => $request->kelompok,
                'manpro' => $request->manpro,
                'periode' => $request->periode,
                'status' => 'pending',
            ]);
        }

        // Buat akun dan anggota
        foreach ($request->anggota as $nim) {
            AkunMahasiswa::firstOrCreate(
                ['nim' => $nim],
                [
                    'kode_tim' => $kode_tim,
                    'password' => Hash::make($nim),
                    'role' => 'mahasiswa',
                ]
            );

            Anggota_Tim_Pbl::create([
                'kode_tim' => $kode_tim,
                'nim' => $nim,
            ]);
        }

        // Ambil nama manpro dari relasi (jika ada)
        $timModel = regMahasiswa::with('manproFK')->where('kode_tim', $kode_tim)->first();
        $namaManpro = $timModel->manproFK->nama ?? '-';

        // Ambil data periode
        $periode = PeriodePBL::find($request->periode);

        // Ambil nama anggota dari Mahasiswa
        $anggota = collect($request->anggota)->map(function ($nim) {
            $nama = Mahasiswa::where('nim', $nim)->value('nama');
            return ['nim' => $nim, 'nama' => $nama ?? '-'];
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
