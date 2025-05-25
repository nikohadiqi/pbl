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
        $selectedKelas = $request->input('kelas', session('selected_kelas'));

        if ($request->has('kelas')) {
            session(['selected_kelas' => $selectedKelas]);
        }

        $kelasList = Pengampu::where('dosen_id', $auth->nim)
            ->with('kelasFk')
            ->get()
            ->pluck('kelasFk.kelas', 'kelasFk.kelas')
            ->unique();

        $mahasiswa = $pengampu = $nilaiMahasiswa = collect();

        if ($selectedKelas) {
            $mahasiswa = Mahasiswa::where('kelas', $selectedKelas)->get();
            $pengampu = Pengampu::where('dosen_id', $auth->nim)->where('kelas_id', $selectedKelas)->get();
            $nilaiMahasiswa = NilaiMahasiswa::whereIn('pengampu_id', $pengampu->pluck('id'))->get();
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

    public function show($nim)
    {
        $auth = Auth::guard('dosen')->user();
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

        $pengampu = Pengampu::where('dosen_id', $auth->nim)
            ->where('kelas_id', $mahasiswa->kelas)
            ->firstOrFail();

        $isManajer = $pengampu->status === 'Manajer Proyek';
        $isDosenMatkul = $pengampu->status === 'Dosen Mata Kuliah';

        $aspekSoftSkill = $this->getAspekSoftSkill();
        $aspekAkademik = $this->getAspekAkademik();
        $bobot = $this->getBobotNilai();

        $nilaiMahasiswa = NilaiMahasiswa::where('nim', $nim)
            ->where('pengampu_id', $pengampu->id)
            ->first();

        $nilaiSoftSkillManpro = $nilaiDosenMatkul = $nilaiAspekGabungan = [];

        if ($isDosenMatkul) {
            $nilaiSoftSkillManpro = $this->getNilaiSoftSkillDariManpro($mahasiswa->kelas, $nim);
            $nilaiDosenMatkul = $this->getNilaiAkademikDosen($nilaiMahasiswa, $aspekAkademik);
            $nilaiAspekGabungan = array_merge($nilaiSoftSkillManpro, $nilaiDosenMatkul);
        } elseif ($isManajer && $nilaiMahasiswa) {
            $nilaiAspekGabungan = json_decode($nilaiMahasiswa->nilai_aspek_json, true);
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

    public function store(Request $request, $nim)
    {
        $auth = Auth::guard('dosen')->user();
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();
        $pengampu = Pengampu::where('dosen_id', $auth->nim)->where('kelas_id', $mahasiswa->kelas)->firstOrFail();

        $isManajer = $pengampu->status === 'Manajer Proyek';
        $isDosenMatkul = $pengampu->status === 'Dosen Mata Kuliah';

        $aspekSoftSkill = $this->getAspekSoftSkill();
        $aspekAkademik = $this->getAspekAkademik();
        $bobot = $this->getBobotNilai();

        //  ℹ️ validasi input
        $rules = [];
        $aspek = [];

        if ($isManajer) {
            $aspek = array_merge($aspekSoftSkill, $aspekAkademik);
        } elseif ($isDosenMatkul) {
            $aspek = $aspekAkademik;
        }

        foreach ($aspek as $a) {
            $rules["nilai_$a"] = 'required|in:1,2,3,4';
            $messages["nilai_$a.required"] = "Nilai untuk aspek $a wajib diisi.";
            $messages["nilai_$a.in"] = "Nilai untuk aspek $a harus berupa angka 1 sampai 4.";
        }

        $request->validate($rules, $messages);

        $nilaiPerAspek = [];
        $total = $totalBobot = 0;

        if ($isManajer) {
            foreach (array_merge($aspekSoftSkill, $aspekAkademik) as $aspek) {
                $nilai = intval($request->input("nilai_$aspek", 0));
                $nilaiPerAspek[$aspek] = $nilai;
                $total += ($bobot[$aspek] ?? 0) * $nilai;
                $totalBobot += $bobot[$aspek] ?? 0;
            }
        } elseif ($isDosenMatkul) {
            $nilaiSoftSkillManpro = $this->getNilaiSoftSkillDariManpro($mahasiswa->kelas, $nim);
            foreach ($aspekAkademik as $aspek) {
                $nilai = intval($request->input("nilai_$aspek", 0));
                $nilaiPerAspek[$aspek] = $nilai;
                $total += ($bobot[$aspek] ?? 0) * $nilai;
                $totalBobot += $bobot[$aspek] ?? 0;
            }
            foreach ($aspekSoftSkill as $aspek) {
                $nilai = $nilaiSoftSkillManpro[$aspek] ?? 0;
                $nilaiPerAspek[$aspek] = $nilai;
                $total += ($bobot[$aspek] ?? 0) * $nilai;
                $totalBobot += $bobot[$aspek] ?? 0;
            }
        } else {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki hak akses menilai mahasiswa ini.');
            return redirect()->route('dosen.penilaian');
        }

        $skorSkala = $totalBobot ? $total / $totalBobot : 0;
        $angka = $skorSkala * 25;
        $huruf = $this->konversiHuruf($angka);

        $data = array_merge([
            'nilai_aspek_json' => json_encode($nilaiPerAspek),
            'total_nilai' => $skorSkala,
            'angka_nilai' => $angka,
            'huruf_nilai' => $huruf,
            'dosen_id' => $auth->nip,
        ], $nilaiPerAspek);

        NilaiMahasiswa::updateOrCreate([
            'nim' => $nim,
            'pengampu_id' => $pengampu->id
        ], $data);

        Alert::success('Berhasil!', 'Nilai berhasil disimpan.');
        return redirect()->route('dosen.penilaian');
    }

    private function konversiHuruf($angka)
    {
        return match (true) {
            $angka >= 85 => 'A',
            $angka >= 80 => 'A-',
            $angka >= 75 => 'B+',
            $angka >= 70 => 'B',
            $angka >= 65 => 'B-',
            $angka >= 60 => 'C+',
            $angka >= 55 => 'C',
            $angka >= 50 => 'C-',
            $angka >= 40 => 'D',
            default => 'E'
        };
    }

    private function getAspekSoftSkill()
    {
        return [
            'critical_thinking',
            'kolaborasi',
            'kreativitas',
            'komunikasi',
            'fleksibilitas',
            'kepemimpinan',
            'produktifitas',
            'social_skill'
        ];
    }

    private function getAspekAkademik()
    {
        return [
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
    }

    private function getBobotNilai()
    {
        return [
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
    }

    private function getNilaiSoftSkillDariManpro($kelasId, $nim)
    {
        $pengampuManpro = Pengampu::where('kelas_id', $kelasId)->where('status', 'Manajer Proyek')->first();
        if (!$pengampuManpro) return [];

        $nilai = NilaiMahasiswa::where('nim', $nim)->where('pengampu_id', $pengampuManpro->id)->first();
        return $nilai ? json_decode($nilai->nilai_aspek_json, true) : [];
    }

    private function getNilaiAkademikDosen($nilaiMahasiswa, $aspekAkademik)
    {
        $nilaiDosenMatkul = [];

        if ($nilaiMahasiswa) {
            $nilaiDecoded = json_decode($nilaiMahasiswa->nilai_aspek_json, true);

            foreach ($aspekAkademik as $aspek) {
                if (isset($nilaiDecoded[$aspek])) {
                    $nilaiDosenMatkul[$aspek] = $nilaiDecoded[$aspek];
                }
            }
        }

        return $nilaiDosenMatkul;
    }
}
