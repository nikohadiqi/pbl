<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TahapanPelaksanaanImport;
use Illuminate\Http\Request;
use App\Models\TahapanPelaksanaanProyek;
use App\Models\PeriodePBL;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class TahapanPelaksanaanProyekController extends Controller
{
    public function index()
    {
        $periodeAktif = PeriodePBL::where('status', 'Aktif')->first();

        if (!$periodeAktif) {
            Alert::warning('Tidak Ada Periode Aktif', 'Silakan aktifkan satu periode PBL terlebih dahulu.');
            return back();
        }

        $tahapan = TahapanPelaksanaanProyek::where('periode_id', $periodeAktif->id)->get();

        return view('admin.tahapan-pelaksanaan.tahapan-pelaksanaan-proyek', compact('tahapan', 'periodeAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahapan.*' => 'nullable|string|max:255',
            'score.*' => 'nullable|numeric|min:5|max:10',
        ]);

        $periodeAktif = PeriodePBL::where('status', 'Aktif')->firstOrFail();

        $totalScore = collect($request->score)->filter()->sum();
        if ($totalScore > 100) {
            Alert::error('Gagal', 'Total score tidak boleh lebih dari 100%');
            return back()->withInput();
        }

        TahapanPelaksanaanProyek::where('periode_id', $periodeAktif->id)->delete();

        foreach ($request->tahapan as $index => $tahapan) {
            if ($tahapan && $request->score[$index]) {
                TahapanPelaksanaanProyek::create([
                    'periode_id' => $periodeAktif->id,
                    'tahapan' => $tahapan,
                    'score' => $request->score[$index],
                ]);
            }
        }

        Alert::success('Berhasil', 'Data tahapan berhasil disimpan.');
        return redirect()->route('admin.tpp');
    }

    public function reset()
    {
        $periodeAktif = PeriodePBL::where('status', 'Aktif')->firstOrFail();

        TahapanPelaksanaanProyek::where('periode_id', $periodeAktif->id)->delete();

        Alert::success('Berhasil', 'Semua tahapan untuk periode aktif berhasil di-reset.');
        return redirect()->route('admin.tpp');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $periodeAktif = PeriodePBL::where('status', 'Aktif')->firstOrFail();

        try {
            Excel::import(new TahapanPelaksanaanImport($periodeAktif->id), $request->file('file'));
            Alert::success('Berhasil', 'Tahapan berhasil diimpor!');
        } catch (\Exception $e) {
            Alert::error('Gagal', $e->getMessage());
        }

        return redirect()->route('admin.tpp');
    }
}
