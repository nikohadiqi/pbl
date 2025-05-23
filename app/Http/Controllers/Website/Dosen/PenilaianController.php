<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\NilaiMahasiswa;
use App\Models\Pengampu;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $auth = Auth::guard('dosen')->user();
        $kelas = $request->input('kelas');
        $mahasiswa = collect();

        if ($kelas) {
            $mahasiswa = Mahasiswa::where('kelas', $kelas)->get();
        }

        return view('dosen.penilaian.penilaian', compact('mahasiswa', 'auth', 'kelas'));
    }

    public function formNilai(Request $request, $nim)
    {
        $auth = Auth::guard('dosen')->user();
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

        // Pastikan dosen adalah pengampu kelas mahasiswa
        $pengampu = Pengampu::where('dosen_id', $auth->nim)  // biasanya dosen id pakai nip, bukan nim
             ->where('kelas_id', $mahasiswa->kelas)
    ->first();

if (!$pengampu) {
    abort(403, 'Anda tidak memiliki akses menilai mahasiswa ini.');
}

// Pisahkan aspek berdasarkan status
$aspekSoftSkill = [
    'critical_thinking', 'kolaborasi', 'kreativitas', 'komunikasi', 'fleksibilitas',
    'kepemimpinan', 'produktifitas', 'social_skill'
];

$aspekAkademik = [
    'konten', 'tampilan_visual_presentasi', 'kosakata', 'tanya_jawab', 'mata_gerak_tubuh',
    'penulisan_laporan', 'pilihan_kata', 'konten_2', 'sikap_kerja', 'proses', 'kualitas'
];

        $bobot = [
            'critical_thinking' => 5,
            'kolaborasi' => 5,
            'kreativitas' => 5,
            'komunikasi' => 5,
            'fleksibilitas' => 5,
            'kepemimpinan' => 5,
            'produktifitas' => 10,
            'social_skill' => 5,
            'konten' => 2,
            'tampilan_visual_presentasi' => 2,
            'kosakata' => 2,
            'tanya_jawab' => 2,
            'mata_gerak_tubuh' => 2,
            'penulisan_laporan' => 3,
            'pilihan_kata' => 2,
            'konten_2' => 2,
            'sikap_kerja' => 8,
            'proses' => 15,
            'kualitas' => 15
        ];
// Ambil nilai dari dosen saat ini (pengampu)
$nilaiMahasiswa = NilaiMahasiswa::where('nim', $nim)
    ->where('pengampu_id', $pengampu->id)
    ->first();

$nilaiAspekGabungan = $nilaiMahasiswa ? json_decode($nilaiMahasiswa->nilai_aspek_json, true) : [];

$isManajer = $pengampu->status === 'Manajer Proyek';
$isDosenMatkul = $pengampu->status === 'Dosen Mata Kuliah';

$aspekAktif = $isManajer ? $aspekSoftSkill : $aspekAkademik;

if ($request->isMethod('post')) {
    $total = 0;
    $totalBobot = 0;
    $nilaiPerAspek = [];

    foreach ($aspekAktif as $index => $namaAspek) {
        $nilai = $request->input("nilai$index");
        $nilai = $nilai !== null ? intval($nilai) : 0;
        $bobotValue = $bobot[$namaAspek] ?? 0;

        $total += $bobotValue * $nilai;
        $totalBobot += $bobotValue;
        $nilaiPerAspek[$namaAspek] = $nilai;
    }

    $skorSkala = $totalBobot > 0 ? $total / $totalBobot : 0;
    $angka = $skorSkala * 25;
    $huruf = $this->konversiHuruf($angka);

    NilaiMahasiswa::updateOrCreate(
        ['nim' => $nim, 'pengampu_id' => $pengampu->id],
        [
            'total_nilai' => $total,
            'angka_nilai' => $angka,
            'huruf_nilai' => $huruf,
            'nilai_aspek_json' => json_encode($nilaiPerAspek),
            'dosen_id' => $auth->nim,
        ]
    );

    return redirect()->route('dosen.penilaian.beri-nilai', $nim)
        ->with('success', 'Nilai berhasil disimpan.');
}

return view('dosen.penilaian.form-nilai', compact(
    'mahasiswa', 'auth', 'aspekSoftSkill', 'aspekAkademik', 'bobot',
    'nilaiAspekGabungan', 'pengampu'
));
    }
    private function konversiHuruf($nilai)
    {
        if ($nilai >= 85) return 'A';
        if ($nilai >= 80) return 'A-';
        if ($nilai >= 75) return 'B+';
        if ($nilai >= 70) return 'B';
        if ($nilai >= 65) return 'B-';
        if ($nilai >= 60) return 'C+';
        if ($nilai >= 55) return 'C';
        if ($nilai >= 50) return 'D';
        return 'E';
    }
}
