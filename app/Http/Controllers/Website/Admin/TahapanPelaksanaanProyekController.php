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
    public function index(Request $request)
    {
        $periodes = PeriodePBL::orderBy('tahun', 'desc')->get();
        $selectedPeriode = $request->periode_id;

        $tahapan = collect();
        $periodepbl = null;

        if ($selectedPeriode) {
            $periodepbl = PeriodePBL::find($selectedPeriode);
            $tahapan = TahapanPelaksanaanProyek::where('periode_id', $selectedPeriode)->get();
        }

        return view('admin.tahapan-pelaksanaan.tahapan-pelaksanaan-proyek', compact('periodes', 'selectedPeriode', 'tahapan', 'periodepbl'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodepbl,id',
            'tahapan.*' => 'nullable|string|max:255',
            'score.*' => 'nullable|numeric|min:5|max:10',
        ]);

        $totalScore = collect($request->score)->filter()->sum();
        if ($totalScore > 100) {
            Alert::error('Gagal', 'Total score tidak boleh lebih dari 100%');
            return back()->withInput();
        }

        TahapanPelaksanaanProyek::where('periode_id', $request->periode_id)->delete();

        foreach ($request->tahapan as $index => $tahapan) {
            if ($tahapan && $request->score[$index]) {
                TahapanPelaksanaanProyek::create([
                    'periode_id' => $request->periode_id,
                    'tahapan' => $tahapan,
                    'score' => $request->score[$index],
                ]);
            }
        }

        Alert::success('Berhasil', 'Data tahapan berhasil disimpan.');
        return redirect()->route('admin.tpp', ['periode_id' => $request->periode_id]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodepbl,id',
        ]);

        TahapanPelaksanaanProyek::where('periode_id', $request->periode_id)->delete();

        Alert::success('Berhasil', 'Semua tahapan untuk periode berhasil di-reset.');
        return redirect()->route('admin.tpp', ['periode_id' => $request->periode_id]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodepbl,id',
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new TahapanPelaksanaanImport($request->periode_id), $request->file('file'));
            Alert::success('Berhasil', 'Tahapan berhasil diimpor!');
        } catch (\Exception $e) {
            Alert::error('Gagal', $e->getMessage());
        }

        return redirect()->route('admin.tpp', ['periode_id' => $request->periode_id]);
    }
}
