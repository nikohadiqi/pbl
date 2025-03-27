<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tpp_sem5; // Model yang digunakan sesuai dengan yang kamu minta

class TPP5Controller extends Controller
{
    // Menampilkan daftar tahapan pelaksanaan semester 5
    public function index()
    {
        $tahapan = Tpp_sem5::orderBy('id', 'asc')->get();
        return view('admin.tahapan-pelaksanaan.semester5.tahapan-pelaksanaan', compact('tahapan'));
    }

    // Menampilkan form tambah tahapan pelaksanaan
    public function create()
    {
        return view('admin.tahapan-pelaksanaan.semester5.tambah-tahapan-pelaksanaan');
    }

    // Menyimpan data tahapan pelaksanaan
    public function store(Request $request)
    {
        $request->validate([
            'tahapan' => 'required|string|max:255',
            'pic' => 'required|string|in:Ketua Tim,Anggota Tim',
            'score' => 'required|numeric|min:5|max:10',
        ]);

        Tpp_sem5::create([
            'tahapan' => $request->tahapan,
            'pic' => $request->pic,
            'score' => $request->score,
        ]);

        return redirect()->route('admin.tahapanpelaksanaan-sem5')->with('success', 'Data berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $tahapan = Tpp_sem5::findOrFail($id);
        return view('admin.tahapan-pelaksanaan.semester5.edit-tahapan-pelaksanaan', compact('tahapan'));
    }

    // Memperbarui data tahapan pelaksanaan
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahapan' => 'required|string|max:255',
            'pic' => 'required|string|in:Ketua Tim,Anggota Tim',
            'score' => 'required|numeric|min:5|max:10',
        ]);

        $tahapan = Tpp_sem5::findOrFail($id);
        $tahapan->update([
            'tahapan' => $request->tahapan,
            'pic' => $request->pic,
            'score' => $request->score,
        ]);

        return redirect()->route('admin.tahapanpelaksanaan-sem5')->with('success', 'Data berhasil diperbarui!');
    }

    // Menghapus data tahapan pelaksanaan
    public function destroy($id)
    {
        $tahapan = Tpp_sem5::findOrFail($id);
        $tahapan->delete();

        return redirect()->route('admin.tahapanpelaksanaan-sem5')->with('success', 'Data berhasil dihapus!');
    }
}
