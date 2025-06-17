<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\NilaiMahasiswa;
use App\Models\Pengampu;
use App\Models\PeriodePBL;
use App\Models\RubrikPenilaian;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

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

        $aspekSoftSkill = $this->getRubrikSoftskill();
        $aspekAkademik = $this->getRubrikAkademik();
        $bobot = $this->getBobotRubrik();

        $nilaiMahasiswa = NilaiMahasiswa::where('nim', $nim)
            ->where('pengampu_id', $pengampu->id)
            ->first();

        $nilaiSoftSkillManpro = $nilaiDosenMatkul = $nilaiAspekGabungan = [];

        switch ($pengampu->status) {
            case 'Dosen Mata Kuliah':
                $nilaiSoftSkillManpro = $this->getNilaiSoftSkillDariManpro($mahasiswa->kelas, $nim);
                $nilaiDosenMatkul = $this->getNilaiAkademikDosen($nilaiMahasiswa, $aspekAkademik);
                $nilaiAspekGabungan = array_merge($nilaiSoftSkillManpro, $nilaiDosenMatkul);
                break;

            case 'Manajer Proyek':
                if ($nilaiMahasiswa) {
                    $nilaiAspekGabungan = json_decode($nilaiMahasiswa->nilai_aspek_json, true);
                }
                break;
        }

        $aspekSoftSkillSlug = array_map(fn($v) => Str::slug($v, '_'), $aspekSoftSkill);
        $aspekAkademikSlug = array_map(fn($v) => Str::slug($v, '_'), $aspekAkademik);

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
            'pengampu',
            'aspekSoftSkillSlug',
            'aspekAkademikSlug',
        ));
    }

    public function store(Request $request, $nim)
    {
        $auth = Auth::guard('dosen')->user();
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();
        $pengampu = Pengampu::where('dosen_id', $auth->nim)->where('kelas_id', $mahasiswa->kelas)->firstOrFail();

        $isManajer = $pengampu->status === 'Manajer Proyek';
        $isDosenMatkul = $pengampu->status === 'Dosen Mata Kuliah';

        $aspekSoftSkill = $this->getRubrikSoftskill();
        $aspekAkademik = $this->getRubrikAkademik();
        $bobot = $this->getBobotRubrik();

        //  ℹ️ validasi input
        $rules = [];
        $aspek = [];

        if ($isManajer) {
            $aspek = array_merge($aspekSoftSkill, $aspekAkademik);
        } elseif ($isDosenMatkul) {
            $aspek = $aspekAkademik;
        }

        foreach ($aspek as $a) {
            $slug = Str::slug($a, '_');
            $rules["nilai_$slug"] = 'required|in:1,2,3,4';
            $messages["nilai_$slug.required"] = "Nilai untuk aspek $a wajib diisi.";
            $messages["nilai_$slug.in"] = "Nilai untuk aspek $a harus berupa angka 1 sampai 4.";
        }

        $request->validate($rules, $messages);

        $nilaiPerAspek = [];
        $total = $totalBobot = 0;

        if ($isManajer) {
            foreach (array_merge($aspekSoftSkill, $aspekAkademik) as $aspek) {
                $slug = Str::slug($aspek, '_');
                $nilai = intval($request->input("nilai_$slug", 0));
                $nilaiPerAspek[$aspek] = $nilai;
                $total += ($bobot[$aspek] ?? 0) * $nilai;
                $totalBobot += $bobot[$aspek] ?? 0;
            }
        } elseif ($isDosenMatkul) {
            $nilaiSoftSkillManpro = $this->getNilaiSoftSkillDariManpro($mahasiswa->kelas, $nim);
            foreach ($aspekAkademik as $aspek) {
                $slug = Str::slug($aspek, '_');
                $nilai = intval($request->input("nilai_$slug", 0));
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

        $data = [
            'nilai_aspek_json' => json_encode($nilaiPerAspek),
            'total_nilai' => $skorSkala,
            'angka_nilai' => $angka,
            'huruf_nilai' => $huruf,
            'dosen_id' => $auth->nim,
        ];

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
            $angka >= 81 => 'A',
            $angka >= 76 => 'AB',
            $angka >= 66 => 'B',
            $angka >= 61 => 'BC',
            $angka >= 56 => 'C',
            $angka >= 41 => 'D',
            default => 'E'
        };
    }

    private function getRubrikSoftskill()
    {
        return RubrikPenilaian::where('jenis', 'softskill')->pluck('aspek_penilaian', 'aspek_penilaian')->toArray();
    }

    private function getRubrikAkademik()
    {
        return RubrikPenilaian::where('jenis', 'akademik')->pluck('aspek_penilaian', 'aspek_penilaian')->toArray();
    }

    private function getBobotRubrik()
    {
        return RubrikPenilaian::pluck('bobot', 'aspek_penilaian')->toArray();
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
        $semesterTahun = $pengampu->periodeFK->kategori_semester . '-' . $pengampu->periodeFK->tahun ?? '-';
        $namaDosen  = $pengampu->dosenFk->nama ?? '-';
        $aspekList = RubrikPenilaian::get();

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

        // Isi Sheet "Tabel Penilaian" untuk daftar aspek dan bobot
        $tabelSheet = $spreadsheet->getSheetByName('Tabel Penilaian');
        if ($tabelSheet) {
            $row = 14;
            foreach ($aspekList as $aspek) {
                $tabelSheet->setCellValue("E{$row}", $aspek->aspek_penilaian);
                $tabelSheet->setCellValue("F{$row}", $aspek->bobot . '%');
                $row++;
            }
        } else {
            $available = implode(', ', $spreadsheet->getSheetNames());
            abort(500, 'Sheet "Tabel Penilaian" tidak ditemukan. Sheet yang tersedia: ' . $available);
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

        // header bobot di Kolom 'E'
        $startCol = Coordinate::columnIndexFromString('E');
        $mapKolom = [];

        foreach ($aspekList as $i => $aspek) {
            $col = Coordinate::stringFromColumnIndex($startCol + $i);
            $mapKolom[$aspek->aspek_penilaian] = $col;
            $sheet->setCellValue($col . '18', $aspek->bobot . '%');
        }

        $row = 19;
        $no = 1;
        foreach ($nilaiMahasiswa as $rowData) {
            $sheet->setCellValue("B{$row}", $no++);
            $sheet->setCellValue("C{$row}", $rowData->nim);
            $sheet->setCellValue("D{$row}", $rowData->mahasiswa->nama ?? '');

            $json = json_decode($rowData->nilai_aspek_json, true) ?? [];

            foreach ($mapKolom as $aspek => $col) {
                $val = is_array($json[$aspek] ?? null)
                    ? ($json[$aspek]['nilai'] ?? '')
                    : ($json[$aspek] ?? '');
                $sheet->setCellValue("{$col}{$row}", $val);
            }

            $row++;
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
