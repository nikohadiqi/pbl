<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\NilaiMahasiswa;
use App\Models\Pengampu;
use RealRashid\SweetAlert\Facades\Alert;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $auth = Auth::guard('dosen')->user();

        // Ambil dari input jika ada, kalau tidak ambil dari session
        $selectedKelas = $request->input('kelas', session('selected_kelas'));

        // Jika user memilih kelas baru, simpan ke session
        if ($request->has('kelas')) {
            session(['selected_kelas' => $selectedKelas]);
        }

        $kelasList = Pengampu::where('dosen_id', $auth->nim)
            ->with('kelasFk')
            ->get()
            ->pluck('kelasFk.kelas', 'kelasFk.kelas')
            ->unique();

        $mahasiswa = collect();
        $pengampu = collect();
        $nilaiMahasiswa = collect();

        if ($selectedKelas) {
            $mahasiswa = Mahasiswa::where('kelas', $selectedKelas)->get();

            $pengampu = Pengampu::where('dosen_id', $auth->nim)
                ->where('kelas_id', $selectedKelas)
                ->get();

            $pengampuIds = $pengampu->pluck('id');

            $nilaiMahasiswa = NilaiMahasiswa::whereIn('pengampu_id', $pengampuIds)->get();
        }

        return view('dosen.penilaian.penilaian', compact(
            'mahasiswa',
            'auth',
            'kelasList',
            'selectedKelas',
            'pengampu',
            'nilaiMahasiswa'
        ));
    }

    // Menampilkan form penilaian
    public function showFormNilai($nim)
    {
        $auth = Auth::guard('dosen')->user();
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

        // Cek dosen sebagai pengampu
        $pengampu = Pengampu::where('dosen_id', $auth->nim)
            ->where('kelas_id', $mahasiswa->kelas)
            ->firstOrFail();

        $isManajer = $pengampu->status === 'Manajer Proyek';
        $isDosenMatkul = $pengampu->status === 'Dosen Mata Kuliah';

        $aspekSoftSkill = [
            'critical_thinking',
            'kolaborasi',
            'kreativitas',
            'komunikasi',
            'fleksibilitas',
            'kepemimpinan',
            'produktifitas',
            'social_skill'
        ];

        $aspekAkademik = [
            'konten_presentasi',
            'tampilan_visual_presentasi',
            'kosakata',
            'tanya_jawab',
            'mata_gerak_tubuh',
            'penulisan_laporan',
            'pilihan_kata',
            'konten_laporan',
            'sikap_kerja',
            'proses',
            'kualitas'
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
            'konten_presentasi' => 2,
            'tampilan_visual_presentasi' => 2,
            'kosakata' => 2,
            'tanya_jawab' => 2,
            'mata_gerak_tubuh' => 2,
            'penulisan_laporan' => 3,
            'pilihan_kata' => 2,
            'konten_laporan' => 2,
            'sikap_kerja' => 8,
            'proses' => 15,
            'kualitas' => 15
        ];

        // Ambil nilai dosen ini
        $nilaiMahasiswa = NilaiMahasiswa::where('nim', $nim)
            ->where('pengampu_id', $pengampu->id)
            ->first();

        // Ambil nilai softskill dari Manajer Proyek untuk dosen matkul
        $nilaiSoftSkillManpro = [];
        if ($isDosenMatkul) {
            $pengampuManpro = Pengampu::where('kelas_id', $mahasiswa->kelas)
                ->where('status', 'Manajer Proyek')
                ->first();

            if ($pengampuManpro) {
                $nilaiSoft = NilaiMahasiswa::where('nim', $nim)
                    ->where('pengampu_id', $pengampuManpro->id)
                    ->first();

                if ($nilaiSoft) {
                    $nilaiSoftSkillManpro = json_decode($nilaiSoft->nilai_aspek_json, true);
                }
            }
        }

        // Nilai Dosen MK
        $nilaiDosenMatkul = [];
        if ($isDosenMatkul && $nilaiMahasiswa) {
            $nilaiDecoded = json_decode($nilaiMahasiswa->nilai_aspek_json, true);
            foreach ($aspekAkademik as $aspek) {
                if (isset($nilaiDecoded[$aspek])) {
                    $nilaiDosenMatkul[$aspek] = $nilaiDecoded[$aspek];
                }
            }
        }

        // Prepare nilai gabungan untuk form (softskill + akademik)
        $nilaiAspekGabungan = [];

        if ($isManajer && $nilaiMahasiswa) {
            $nilaiAspekGabungan = json_decode($nilaiMahasiswa->nilai_aspek_json, true);
        } elseif ($isDosenMatkul) {
            // SoftSkill dari Manpro
            $nilaiAspekGabungan = $nilaiSoftSkillManpro;

            // Tambahkan nilai akademik dari dosen matkul
            if ($nilaiMahasiswa) {
                $nilaiAkademik = json_decode($nilaiMahasiswa->nilai_aspek_json, true);
                foreach ($aspekAkademik as $aspek) {
                    $nilaiAspekGabungan[$aspek] = $nilaiAkademik[$aspek] ?? null;
                }
            }
        }

        return view('dosen.penilaian.form-nilai', compact(
            'mahasiswa',
            'auth',
            'aspekSoftSkill',
            'aspekAkademik',
            'bobot',
            'nilaiMahasiswa',
            'nilaiSoftSkillManpro',
            'nilaiAspekGabungan',
            'isManajer',
            'isDosenMatkul',
            'nilaiDosenMatkul',
            'pengampu'
        ));
    }

    public function storeNilai(Request $request, $nim)
    {
        $auth = Auth::guard('dosen')->user();
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

        $pengampu = Pengampu::where('dosen_id', $auth->nim)
            ->where('kelas_id', $mahasiswa->kelas)
            ->firstOrFail();

        $isManajer = $pengampu->status === 'Manajer Proyek';
        $isDosenMatkul = $pengampu->status === 'Dosen Mata Kuliah';

        $aspekSoftSkill = [
            'critical_thinking',
            'kolaborasi',
            'kreativitas',
            'komunikasi',
            'fleksibilitas',
            'kepemimpinan',
            'produktifitas',
            'social_skill'
        ];

        $aspekAkademik = [
            'konten_presentasi',
            'tampilan_visual_presentasi',
            'kosakata',
            'tanya_jawab',
            'mata_gerak_tubuh',
            'penulisan_laporan',
            'pilihan_kata',
            'konten_laporan',
            'sikap_kerja',
            'proses',
            'kualitas'
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
            'konten_presentasi' => 2,
            'tampilan_visual_presentasi' => 2,
            'kosakata' => 2,
            'tanya_jawab' => 2,
            'mata_gerak_tubuh' => 2,
            'penulisan_laporan' => 3,
            'pilihan_kata' => 2,
            'konten_laporan' => 2,
            'sikap_kerja' => 8,
            'proses' => 15,
            'kualitas' => 15
        ];

        $nilaiPerAspek = [];
        $total = 0;
        $totalBobot = 0;

        if ($isManajer) {
            // Manajer proyek input semua aspek
            $allAspek = array_merge($aspekSoftSkill, $aspekAkademik);

            foreach ($allAspek as $index => $aspek) {
                $nilai = $request->input("nilai_$aspek");
                $nilai = $nilai !== null ? intval($nilai) : 0;

                $nilaiPerAspek[$aspek] = $nilai;

                $bobotValue = $bobot[$aspek] ?? 0;
                $total += $bobotValue * $nilai;
                $totalBobot += $bobotValue;
            }
        } elseif ($isDosenMatkul) {
            // Dosen Matkul input akademik, softskill dari Manpro

            // Ambil nilai softskill dari Manpro
            $pengampuManpro = Pengampu::where('kelas_id', $mahasiswa->kelas)
                ->where('status', 'Manajer Proyek')
                ->first();

            $nilaiSoftSkillManpro = [];
            if ($pengampuManpro) {
                $nilaiSoft = NilaiMahasiswa::where('nim', $nim)
                    ->where('pengampu_id', $pengampuManpro->id)
                    ->first();

                if ($nilaiSoft) {
                    $nilaiSoftSkillManpro = json_decode($nilaiSoft->nilai_aspek_json, true);
                }
            }

            // Input nilai akademik dari form
            foreach ($aspekAkademik as $aspek) {
                $nilai = $request->input("nilai_$aspek");
                $nilai = $nilai !== null ? intval($nilai) : 0;

                $nilaiPerAspek[$aspek] = $nilai;

                $bobotValue = $bobot[$aspek] ?? 0;
                $total += $bobotValue * $nilai;
                $totalBobot += $bobotValue;
            }

            // Tambahkan nilai softskill dari manpro
            foreach ($aspekSoftSkill as $aspek) {
                $nilai = $nilaiSoftSkillManpro[$aspek] ?? 0;
                $nilaiPerAspek[$aspek] = $nilai;

                $bobotValue = $bobot[$aspek] ?? 0;
                $total += $bobotValue * $nilai;
                $totalBobot += $bobotValue;
            }
        } else {
            // Jika status lain (tidak boleh input), bisa return error atau kosong
            return redirect()->back()->with('error', 'Anda tidak berhak memberi nilai.');
        }

        $skorSkala = $totalBobot > 0 ? $total / $totalBobot : 0;
        $angka = $skorSkala * 25;
        $huruf = $this->konversiHuruf($angka);

        $data = [
            'nilai_aspek_json' => json_encode($nilaiPerAspek),
            'total_nilai' => $skorSkala,
            'angka_nilai' => $angka,
            'huruf_nilai' => $huruf,
            'dosen_id' => $auth->nip,
        ];

        // Simpan juga per aspek agar lebih cepat query
        foreach ($nilaiPerAspek as $aspek => $nilai) {
            $data[$aspek] = $nilai;
        }

        NilaiMahasiswa::updateOrCreate(
            ['nim' => $nim, 'pengampu_id' => $pengampu->id],
            $data
        );

        Alert::success('Berhasil!', 'Nilai berhasil disimpan.');
        return redirect()->route('dosen.penilaian');
    }

    private function konversiHuruf($angka)
    {
        if ($angka >= 85) {
            return 'A';
        } elseif ($angka >= 80) {
            return 'A-';
        } elseif ($angka >= 75) {
            return 'B+';
        } elseif ($angka >= 70) {
            return 'B';
        } elseif ($angka >= 65) {
            return 'B-';
        } elseif ($angka >= 60) {
            return 'C+';
        } elseif ($angka >= 55) {
            return 'C';
        } elseif ($angka >= 50) {
            return 'C-';
        } elseif ($angka >= 40) {
            return 'D';
        } else {
            return 'E';
        }
    }
}
