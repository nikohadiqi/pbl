<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tpp_sem4;
use RealRashid\SweetAlert\Facades\Alert;

class TPP4Controller extends Controller
{
    // Menampilkan daftar tahapan pelaksanaan semester 4
    public function index()
    {
        $tahapan = Tpp_sem4::orderBy('id', 'asc')->get();
        return view('admin.tahapan-pelaksanaan.semester4.tahapan-pelaksanaan', compact('tahapan'));
    }

    // Menampilkan form tambah tahapan pelaksanaan
    public function create()
    {
        return view('admin.tahapan-pelaksanaan.semester4.tambah-tahapan-pelaksanaan');
    }

    // Menyimpan data tahapan pelaksanaan
    public function store(Request $request)
    {
        $request->validate([
            'tahapan' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'score' => 'required|integer|min:1|max:100',
        ]);

        Tpp_sem4::create([
            'tahapan' => $request->tahapan,
            'pic' => $request->pic,
            'score' => $request->score,
        ]);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data berhasil ditambahkan!');
        return redirect()->route('admin.tahapanpelaksanaan-sem4');
    }

// Menampilkan form edit
public function edit($id)
{
    $tahapan = Tpp_sem4::findOrFail($id);
    return view('admin.tahapan-pelaksanaan.semester4.edit-tahapan-pelaksanaan', compact('tahapan'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahapan' => 'required|string|max:255',
            'pic' => 'required|string|in:Ketua Tim,Anggota Tim',
            'score' => 'required|numeric|min:5|max:10',
        ]);

        $tahapan = Tpp_sem4::findOrFail($id);
        $tahapan->update([
            'tahapan' => $request->tahapan,
            'pic' => $request->pic,
            'score' => $request->score,
        ]);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data berhasil diperbarui!');
        return redirect()->route('admin.tahapanpelaksanaan-sem4');
    }

    // Menghapus data tahapan pelaksanaan
    public function destroy($id)
    {
        $tahapan = Tpp_sem4::findOrFail($id);
        $tahapan->delete();

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data berhasil dihapus!');
        return redirect()->route('admin.tahapanpelaksanaan-sem4');
    }
}
