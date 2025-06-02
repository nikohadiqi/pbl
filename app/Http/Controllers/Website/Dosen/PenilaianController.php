<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\NilaiMahasiswa;
use App\Models\Pengampu;
use App\Models\PeriodePBL;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $auth = Auth::guard('dosen')->user();
        $selectedKelas = $request->input('kelas', session('selected_kelas'));

        if ($request->has('kelas')) {
            session(['selected_kelas' => $selectedKelas]);
        }

        // Ambil periode aktif
        $periodeAktif = PeriodePBL::where('status', 'Aktif')->first();

        // Jika tidak ada periode aktif, tampilkan kosong
        if (!$periodeAktif) {
            return view('dosen.penilaian.penilaian', [
                'mahasiswa' => collect(),
                'auth' => $auth,
                'kelasList' => collect(),
                'selectedKelas' => null,
                'pengampu' => collect(),
                'nilaiMahasiswa' => collect()
            ]);
        }

        // Ambil daftar kelas berdasarkan pengampu dosen dan periode aktif
        $kelasList = Pengampu::where('dosen_id', $auth->nim)
            ->where('periode_id', $periodeAktif->id)
            ->with('kelasFk')
            ->get()
            ->pluck('kelasFk.kelas', 'kelasFk.kelas')
            ->unique();

        $mahasiswa = $pengampu = $nilaiMahasiswa = collect();

        // Tambahan: Ambil pengampu manpro untuk kelas dan periode yang sama
        $pengampuManpro = Pengampu::where('kelas_id', $selectedKelas)
            ->where('periode_id', $periodeAktif->id)
            ->where('status', 'Manajer Proyek')
            ->first();

        // Ambil semua nilai yang diberikan oleh dosen manpro (jika ada)
        $nilaiManpro = collect();

        if ($selectedKelas) {
            $pengampu = Pengampu::where('dosen_id', $auth->nim)
                ->where('kelas_id', $selectedKelas)
                ->where('periode_id', $periodeAktif->id)
                ->get();

            $mahasiswa = Mahasiswa::where('kelas', $selectedKelas)->get();
            $nilaiMahasiswa = NilaiMahasiswa::whereIn('pengampu_id', $pengampu->pluck('id'))->get();

            if ($pengampuManpro) {
                $nilaiManpro = NilaiMahasiswa::where('pengampu_id', $pengampuManpro->id)->get();
            }
        }

        return view('dosen.penilaian.penilaian', compact(
            'mahasiswa',
            'auth',
            'kelasList',
            'selectedKelas',
            'pengampu',
            'nilaiMahasiswa',
            'nilaiManpro',
            'pengampuManpro'
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

    public function exportExcel(Request $request)
    {
        $selectedKelas = $request->query('kelas');

        if (!$selectedKelas) {
            abort(400, 'Kelas belum dipilih.');
        }

        $auth = Auth::guard('dosen')->user();

        // Cek apakah dosen mengampu kelas ini
        $pengampu = Pengampu::where('dosen_id', $auth->nim)
            ->where('kelas_id', $selectedKelas)
            ->first();

        if (!$pengampu) {
            abort(403, 'Anda tidak mengampu kelas ini.');
        }

        $templatePath = resource_path('templates/rubrik_penilaian_template.xlsx');
        if (!file_exists($templatePath)) {
            abort(500, 'Template Excel tidak ditemukan.');
        }

        $spreadsheet = IOFactory::load($templatePath);

        // Ambil data dari relasi
        $namaMatkul = $pengampu->matkulFk->kode . ' - ' . $pengampu->matkulFk->matakuliah ?? '-';
        $sksMatkul = $pengampu->matkulFk->sks ?? '-';
        $semesterTahun = $pengampu->periodeFK->semester . '/' . $pengampu->periodeFK->tahun ?? '-';
        $namaDosen  = $pengampu->dosenFk->nama ?? '-';

        // Daftar sheet yang ingin diisi datanya
        $targetSheets = ['Rubrik Penilaian', 'Tabel Penilaian'];

        foreach ($targetSheets as $sheetName) {
            $sheetPengampu = $spreadsheet->getSheetByName($sheetName);

            if (!$sheetPengampu) {
                $available = implode(', ', $spreadsheet->getSheetNames());
                abort(500, 'Sheet "' . $sheetName . '" tidak ditemukan. Sheet yang tersedia: ' . $available);
            }

            // Masukkan data ke sel yang sesuai
            $sheetPengampu->setCellValue('C7', sprintf(': %s', $namaMatkul));    // Nama Mata Kuliah
            $sheetPengampu->setCellValue('C8', sprintf(': %s', $sksMatkul));      // SKS
            $sheetPengampu->setCellValue('C9', sprintf(': %s', $semesterTahun));  // Semester/Tahun
            $sheetPengampu->setCellValue('C11', sprintf(': %s', $namaDosen));     // Nama Dosen Pengampu
        }

        // Set sheet "Nilai"
        $sheet = $spreadsheet->getSheetByName('Nilai');
        if (!$sheet) {
            $available = implode(', ', $spreadsheet->getSheetNames());
            abort(500, 'Sheet "Nilai" tidak ditemukan. Sheet yang tersedia: ' . $available);
        }

        $nilaiMahasiswa = NilaiMahasiswa::with('mahasiswa')
            ->where('pengampu_id', $pengampu->id)
            ->get();

        $startRow = 19;
        $rowNum = $startRow;
        $no = 1;

        foreach ($nilaiMahasiswa as $nilai) {
            $sheet->setCellValue('B' . $rowNum, $no++);
            $sheet->setCellValue('C' . $rowNum, $nilai->nim);
            $sheet->setCellValue('D' . $rowNum, $nilai->mahasiswa->nama ?? '');
            $sheet->setCellValue('E' . $rowNum, $nilai->critical_thinking);
            $sheet->setCellValue('F' . $rowNum, $nilai->kolaborasi);
            $sheet->setCellValue('G' . $rowNum, $nilai->kreativitas);
            $sheet->setCellValue('H' . $rowNum, $nilai->komunikasi);
            $sheet->setCellValue('I' . $rowNum, $nilai->fleksibilitas);
            $sheet->setCellValue('J' . $rowNum, $nilai->kepemimpinan);
            $sheet->setCellValue('K' . $rowNum, $nilai->produktifitas);
            $sheet->setCellValue('L' . $rowNum, $nilai->social_skill);
            $sheet->setCellValue('M' . $rowNum, $nilai->konten_presentasi);
            $sheet->setCellValue('N' . $rowNum, $nilai->tampilan_visual_presentasi);
            $sheet->setCellValue('O' . $rowNum, $nilai->kosakata);
            $sheet->setCellValue('P' . $rowNum, $nilai->tanya_jawab);
            $sheet->setCellValue('Q' . $rowNum, $nilai->mata_gerak_tubuh);
            $sheet->setCellValue('R' . $rowNum, $nilai->penulisan_laporan);
            $sheet->setCellValue('S' . $rowNum, $nilai->pilihan_kata);
            $sheet->setCellValue('T' . $rowNum, $nilai->konten_laporan);
            $sheet->setCellValue('U' . $rowNum, $nilai->sikap_kerja);
            $sheet->setCellValue('V' . $rowNum, $nilai->proses);
            $sheet->setCellValue('W' . $rowNum, $nilai->kualitas);
            $rowNum++;
        }

        $namaMatkul = $pengampu->matkulFK->matakuliah ?? 'Nama Mata Kuliah';
        $slug = Str::slug($namaMatkul, ' '); // ex: basis data lanjut
        $namaMatkulTitle = Str::title($slug); // ex: Basis Data Lanjut

        $fileName = "Rubrik Penilaian PBL_Kelas {$selectedKelas}_{$namaMatkulTitle}_" . now()->format('Ymd_His') . ".xlsx";

        return new StreamedResponse(function () use ($spreadsheet) {
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
