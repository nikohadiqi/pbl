<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KelasController extends Controller
{
    // Menampilkan semua kelas
    public function index()
    {
        $kelas = Kelas::all();
        foreach ($kelas as $item) {
            $item->kelas_encoded = base64_encode($item->kelas);
        }
        return view('admin.kelas.kelas', compact('kelas'));
    }

    // Form tambah kelas
    public function create()
    {
        return view('admin.kelas.form-kelas', [
            'action' => route('admin.kelas.store'),
            'isEdit' => false,
        ]);
    }

    // Simpan kelas baru
    public function store(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|integer|min:1|max:3',
            'huruf' => 'required|alpha|size:1',
        ]);

        $tingkat = $request->tingkat;
        $huruf = strtoupper($request->huruf);
        $kelas = $tingkat . $huruf;

        if (Kelas::where('kelas', $kelas)->exists()) {
            return redirect()->back()->withErrors(['kelas' => 'Kelas ini sudah terdaftar.']);
        }

        Kelas::create([
            'kelas' => $kelas,
            'tingkat' => $tingkat,
        ]);

        Alert::success('Berhasil!', 'Data kelas berhasil ditambahkan!');
        return redirect()->route('admin.kelas');
    }

    // Form edit kelas
    public function edit($kelas)
    {
        $kelas = Kelas::findOrFail($kelas);
        return view('admin.kelas.form-kelas', [
            'kelas' => $kelas,
            'action' => route('admin.kelas.update', $kelas->kelas),
            'isEdit' => true,
        ]);
    }

    // Update kelas
    public function update(Request $request, $kelas)
    {
        $request->validate([
            'tingkat' => 'required|integer|min:1|max:3',
            'huruf' => 'required|alpha|size:1',
        ]);

        $tingkat = $request->tingkat;
        $huruf = strtoupper($request->huruf);
        $kelasBaru = $tingkat . $huruf;

        // Cek jika nama kelas baru sudah ada (kecuali jika tidak berubah)
        if ($kelas !== $kelasBaru && Kelas::where('kelas', $kelasBaru)->exists()) {
            return redirect()->back()->withErrors(['kelas' => 'Kelas ini sudah terdaftar.']);
        }

        $kelasModel = Kelas::findOrFail($kelas);
        $kelasModel->delete(); // karena primary key berubah, hapus dulu lama

        Kelas::create([
            'kelas' => $kelasBaru,
            'tingkat' => $tingkat,
        ]);

        Alert::success('Berhasil!', 'Data kelas berhasil diperbarui!');
        return redirect()->route('admin.kelas');
    }

    // Hapus kelas
    public function destroy($kelas)
    {
        $kelas = Kelas::findOrFail($kelas);
        $kelas->delete();

        Alert::success('Berhasil!', 'Data kelas berhasil dihapus!');
        return redirect()->route('admin.kelas');
    }
}
