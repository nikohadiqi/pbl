<?php

namespace App\Http\Controllers\Website\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Logbook;
use App\Models\PelaporanUAS;
use App\Models\PelaporanUTS;
use App\Models\PeriodePBL;
use App\Models\TahapanPelaksanaanProyek;
use App\Models\TimPbl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarTimController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('dosen')->user();
        $timPBL = collect();    // default kosong

        // Data dropdown
        $kelasList = Kelas::pluck('kelas');
        $periodeList = PeriodePBL::where('status', 'aktif')->get();

        // Ambil dari session jika tidak ada request baru
        $kelas = $request->input('kelas', session('filter_kelas'));
        $tahun = $request->input('tahun', session('filter_tahun'));

        // Simpan ke session jika ada input baru
        if ($request->filled('kelas')) {
            session(['filter_kelas' => $kelas]);
        }
        if ($request->filled('tahun')) {
            session(['filter_tahun' => $tahun]);
        }

        // Jika dosen adalah manpro
        if ($user && $user->is_manajer_proyek) {
            $query = TimPbl::with(['anggota.mahasiswaFK', 'manproFK', 'periodeFK', 'rencanaProyek'])
                ->where('status', 'approved')
                ->whereHas('periodeFK', function ($q) {
                    $q->where('status', 'aktif');
                });

            if (!empty($kelas)) {
                $query->where('kelas', $kelas);
            }

            if (!empty($tahun)) {
                $query->where('periode', $tahun);
            }

            if (empty($kelas) && empty($tahun)) {
                $query->where('manpro', $user->nim);
            }

            $timPBL = $query->get();
        }

        // Jika bukan manpro tapi filter lengkap
        elseif (!empty($kelas) && !empty($tahun)) {
            $timPBL = TimPbl::with(['anggota.mahasiswaFK', 'manproFK', 'periodeFK', 'rencanaProyek'])
                ->where('status', 'approved')
                ->where('kelas', $kelas)
                ->where('periode', $tahun)
                ->whereHas('periodeFK', function ($q) {
                    $q->where('status', 'aktif');
                })
                ->get();
        }

        return view('dosen.daftar-tim.daftar-timpbl', compact('timPBL', 'kelasList', 'periodeList', 'kelas', 'tahun'));
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
