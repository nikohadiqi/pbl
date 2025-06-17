<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Logbook;
use App\Models\PelaporanUAS;
use App\Models\PelaporanUTS;
use App\Models\PeriodePBL;
use App\Models\TahapanPelaksanaanProyek;
use App\Models\TimPBL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarTimController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('dosen')->user();
        $timPBL = collect();

        $periodeAktif = PeriodePBL::where('status', 'Aktif')->firstOrFail();
        $semesterList = semesterDariKategori($periodeAktif->kategori_semester);

        $selectedSemester = $request->input('semester', session('filter_semester'));
        $selectedKelas = $request->input('kelas', session('filter_kelas'));

        // Simpan session
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

        if ($user && $user->is_manajer_proyek) {
            $query = TimPBL::with(['anggota.mahasiswaFK', 'manproFK', 'periodeFK', 'rencanaProyek'])
                ->where('status', 'approved')
                ->whereHas('periodeFK', fn($q) => $q->where('status', 'Aktif'));

            if ($selectedKelas) {
                $query->where('kelas', $selectedKelas);
            } else {
                $query->where('manpro', $user->nim);
            }

            $timPBL = $query->get();
        } elseif ($selectedKelas) {
            $timPBL = TimPBL::with(['anggota.mahasiswaFK', 'manproFK', 'periodeFK', 'rencanaProyek'])
                ->where('status', 'approved')
                ->where('kelas', $selectedKelas)
                ->whereHas('periodeFK', fn($q) => $q->where('status', 'Aktif'))
                ->get();
        }

        return view('dosen.daftar-tim.daftar-timpbl', compact(
            'timPBL',
            'periodeAktif',
            'semesterList',
            'selectedSemester',
            'selectedKelas',
            'filteredKelas'
        ));
    }


    public function lihatLogbookTim($kode_tim, Request $request)
    {

        $tim = TimPBL::where('kode_tim', $kode_tim)
            ->first();

        if (!$tim) {
            return redirect()->route('dosen.daftar-tim')->with('error', 'Tim tidak ditemukan.');
        }

        // Ambil semua logbook dan tahapan
        $logbooks = Logbook::where('kode_tim', $kode_tim)->get();

        $tahapans = TahapanPelaksanaanProyek::where('periode_id', $tim->periode)
            ->orderBy('id')
            ->take(16) // batas maksimal 16
            ->get();

        $scores = [];
        foreach ($tahapans as $index => $tahapan) {
            $scores[$index + 1] = $tahapan->score ?? 100;
        }

        $selectedLogbook = null;
        if ($request->has('selectedId')) {
            $selectedLogbook = Logbook::where('kode_tim', $kode_tim)
                ->where('minggu', $request->input('selectedId'))
                ->first();
        }

        return view('dosen.daftar-tim.logbook-timpbl', compact('logbooks', 'selectedLogbook', 'tahapans', 'scores', 'kode_tim'));
    }

    public function lihatLaporanTim($kode_tim)
    {
        $tim = TimPBL::where('kode_tim', $kode_tim)->firstOrFail();
        // Ambil data laporan UTS dan UAS berdasarkan kode_tim
        $pelaporanUTS = PelaporanUTS::where('kode_tim', $kode_tim)->first();
        $pelaporanUAS = PelaporanUAS::where('kode_tim', $kode_tim)->first();

        return view('dosen.daftar-tim.laporan-timpbl', compact('kode_tim', 'pelaporanUTS', 'pelaporanUAS'));
    }
}
