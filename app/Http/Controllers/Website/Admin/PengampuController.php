<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkunDosen;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\Pengampu;
use App\Models\PeriodePBL;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PengampuController extends Controller
{
    // Search Manpro
    public function searchManpro(Request $request)
    {
        $kelas = $request->kelas;
        $periodeId = $request->periode_id;

        $pengampu = Pengampu::where('status', 'Manajer Proyek')
            ->where('kelas_id', $kelas)
            ->where('periode_id', $periodeId)
            ->with('dosenFk')
            ->first();

        if ($pengampu && $pengampu->dosenFk) {
            return response()->json([
                'nip' => $pengampu->dosenFk->nip,
                'nama' => $pengampu->dosenFk->nama,
            ]);
        }

        return response()->json([], 404);
    }

    public function manage(Request $request)
    {
        $periodes = PeriodePBL::where('status', 'Aktif')->firstOrFail();
        $dosen = Dosen::all();

        $semesterList = semesterDariKategori($periodes->kategori_semester);

        // Hanya ambil semester dan kelas jika dikirim lewat request
        $selectedSemester = $request->input('semester', session('filter_semester'));
        $selectedKelas = $request->input('kelas', session('filter_kelas'));

        // Simpan ke session jika ada input baru
        if ($request->filled('semester')) {
            session(['filter_semester' => $selectedSemester]);
        }
        if ($request->filled('kelas')) {
            session(['filter_kelas' => $selectedKelas]);
        }

        $filteredKelas = collect();

        if ($selectedSemester) {
            $tingkat = ceil($selectedSemester / 2);
            $filteredKelas = Kelas::where('tingkat', $tingkat)->get();
        }

        $matkuls = collect();
        $pengampus = collect();

        if ($selectedKelas && $selectedSemester) {
            $matkuls = MataKuliah::where('semester', $selectedSemester)
                ->where('periode_id', $periodes->id)
                ->get();

            $pengampus = Pengampu::where('kelas_id', $selectedKelas)
                ->where('semester', $selectedSemester)
                ->get()
                ->keyBy('matkul_id');
        }

        return view('admin.pengampu.pengampu', compact(
            'periodes',
            'dosen',
            'semesterList',
            'selectedKelas',
            'selectedSemester',
            'filteredKelas',
            'matkuls',
            'pengampus',
        ));
    }


    public function manageStore(Request $request)
    {
        $semester = $request->input('semester');
        $kelasId = $request->input('kelas_id');
        $periodeId = $request->input('periode_id');
        $data = $request->input('data'); // format: ['matkul_id' => ['dosen_id' => ..., 'status' => ...]]

        // Validasi: kelas yang dipilih harus sesuai dengan semester (berdasarkan tingkat)
        $kelas = Kelas::find($kelasId);
        $expectedTingkat = ceil($semester / 2); // misalnya semester 3 → tingkat 2

        if (!$kelas || $kelas->tingkat != $expectedTingkat) {
            Alert::error('Gagal', 'Kelas yang dipilih tidak sesuai dengan semester.');
            session(['filter_semester' => $semester]);
            session(['filter_kelas' => $kelasId]);
            return redirect()->back()->withInput();
        }

        // Validasi: satu dosen hanya boleh mengampu satu matkul di kelas dan periode yang sama
        $dosenDipakai = [];
        $jumlahManpro = 0;

        foreach ($data as $matkulId => $pengampuData) {
            $dosenId = $pengampuData['dosen_id'];
            $status = $pengampuData['status'];

            if (in_array($dosenId, $dosenDipakai)) {
                Alert::error('Gagal', 'Satu dosen hanya boleh mengampu satu mata kuliah untuk kelas dan periode yang sama.');
                session(['filter_semester' => $semester]);
                session(['filter_kelas' => $kelasId]);
                return redirect()->back()->withInput();
            }

            $dosenDipakai[] = $dosenId;

            // CEK: apakah dosen ini sudah menjadi manpro di kelas lain pada periode yang sama
            if ($status === 'Manajer Proyek') {
                $jumlahManpro++;

                $pengampuLain = Pengampu::where('periode_id', $periodeId)
                    ->where('status', 'Manajer Proyek')
                    ->where('dosen_id', $dosenId)
                    ->where('semester', $semester)
                    ->where('kelas_id', '!=', $kelasId)
                    ->with('kelasFK') // load relasi kelas
                    ->first();

                if ($pengampuLain) {
                    $namaDosen = Dosen::find($dosenId)->nama ?? 'Dosen';
                    $namaKelas = $pengampuLain->kelasFK->kelas ?? 'kelas lain';

                    Alert::error('Gagal', "Dosen $namaDosen sudah menjadi Manajer Proyek di Kelas $namaKelas pada periode ini.");
                    session(['filter_semester' => $semester]);
                    session(['filter_kelas' => $kelasId]);
                    return redirect()->back()->withInput();
                }
            }
        }

        // Validasi hanya boleh ada satu Manajer Proyek
        if ($jumlahManpro > 1) {
            Alert::error('Gagal', 'Dalam satu kelas hanya boleh ada satu Manajer Proyek.');
            session(['filter_semester' => $semester]);
            session(['filter_kelas' => $kelasId]);
            return redirect()->back()->withInput();
        }

        // Simpan/update data
        foreach ($data as $matkulId => $pengampuData) {
            Pengampu::updateOrCreate(
                [
                    'semester' => $semester,
                    'kelas_id' => $kelasId,
                    'periode_id' => $periodeId,
                    'matkul_id' => $matkulId,
                ],
                [
                    'dosen_id' => $pengampuData['dosen_id'],
                    'status' => $pengampuData['status'],
                ]
            );

            // Buat akun dosen jika belum ada
            $dosen = Dosen::find($pengampuData['dosen_id']);
            if ($dosen && !AkunDosen::where('nim', $dosen->nip)->exists()) {
                AkunDosen::create([
                    'role' => 'dosen',
                    'nim' => $dosen->nip,
                    'password' => bcrypt($dosen->nip),
                ]);
            }
        }

        Alert::success('Berhasil', 'Data Pengampu berhasil disimpan!');
        return redirect()->route('admin.pengampu');
    }
}
