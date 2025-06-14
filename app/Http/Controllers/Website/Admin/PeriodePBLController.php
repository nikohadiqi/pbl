<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodePBL;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PeriodePBLController extends Controller
{
    public function index()
    {
        $periodePBL = PeriodePBL::orderByRaw("
            CASE
                WHEN status = 'Aktif' THEN 0
                WHEN status = 'Tidak Aktif' THEN 1
                WHEN status = 'Selesai' THEN 2
                ELSE 3
            END
        ")
        ->orderBy('tanggal_mulai', 'asc') // urutan tambahan jika diperlukan
        ->get();

        return view('admin.periode-pbl.periodepbl', compact('periodePBL'));
    }

    public function create()
    {
        return view('admin.periode-pbl.form-periodepbl', [
            'isEdit' => false,
            'periode' => null
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_semester' => 'required|in:Ganjil,Genap',
            'tahun' => 'required|digits:4',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Cek apakah semester & tahun sudah ada
        $existing = PeriodePBL::where('kategori_semester', $request->kategori_semester)
            ->where('tahun', $request->tahun)
            ->first();

        if ($existing) {
            return back()
                ->withInput()
                ->withErrors(['kategori_semester' => 'Kategori Semester pada tahun ini sudah terdaftar.']);
        }

        // Simpan data dengan status default 'Tidak Aktif'
        PeriodePBL::create([
            'kategori_semester' => $request->kategori_semester,
            'tahun' => $request->tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'Tidak Aktif',
        ]);

        Alert::success('Berhasil!', 'Data Periode PBL berhasil ditambahkan (status: Tidak Aktif).');
        return redirect()->route('admin.periodepbl');
    }


    public function edit($id)
    {
        $periode = PeriodePBL::findOrFail($id);
        return view('admin.periode-pbl.form-periodepbl', [
            'isEdit' => true,
            'periode' => $periode
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_semester' => 'required|in:Ganjil,Genap',
            'tahun' => 'required|digits:4',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Cek duplikasi jika semester & tahun diubah
        $existing = PeriodePBL::where('kategori_semester', $request->kategori_semester)
            ->where('tahun', $request->tahun)
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            return back()
                ->withInput()
                ->withErrors(['kategori_semester' => 'Kategori Semester pada tahun ini sudah terdaftar.']);
        }

        $periode = PeriodePBL::findOrFail($id);

        $periode->update([
            'kategori_semester' => $request->kategori_semester,
            'tahun' => $request->tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        Alert::success('Berhasil!', 'Data Periode PBL berhasil diperbarui!');
        return redirect()->route('admin.periodepbl');
    }


    public function destroy($id)
    {
        PeriodePBL::findOrFail($id)->delete();
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Periode PBL berhasil dihapus!');
        return redirect()->route('admin.periodepbl');
    }

    public function bulkDelete(Request $request)
    {
        PeriodePBL::whereIn('id', $request->ids)->delete();
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Periode PBL berhasil dihapus!');
        return redirect()->route('admin.periodepbl');
    }

    // Periode Selesai
    public function selesai($id)
    {
        $periode = PeriodePBL::findOrFail($id);

        if ($periode->status != 'Aktif') {
            return redirect()->back()->with('error', 'Periode sudah tidak aktif.');
        }

        $periode->update([
            'status' => 'Selesai',
            'closed_at' => now(),
            'closed_by' => Auth::id(),
        ]);

        Alert::success('Selesai!', 'Periode telah ditandai sebagai "Selesai Dilaksanakan"!');
        return redirect()->route('admin.periodepbl');
    }

    public function aktifkan($id)
    {
        // Nonaktifkan semua dulu
        PeriodePBL::where('status', 'Aktif')->update(['status' => 'Tidak Aktif']);

        // Aktifkan yang dipilih
        $periode = PeriodePBL::findOrFail($id);
        $periode->update(['status' => 'Aktif', 'closed_at' => null, 'closed_by' => null]);

        Alert::success('Aktif!', 'Periode ini telah "Aktif"!');
        return redirect()->route('admin.periodepbl');
    }
}
