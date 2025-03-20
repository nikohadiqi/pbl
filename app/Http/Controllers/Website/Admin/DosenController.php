<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;

class DosenController extends Controller
{
    // Menampilkan daftar dosen
    public function index()
    {
        $dosen = Dosen::all();
        return view('admin.akun-dosen.dosen', compact('dosen'));
    }

    // Menampilkan form tambah dosen
    public function create()
    {
        return view('admin.akun-dosen.tambah-dosen');
    }

    // Menyimpan data dosen
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:dosen,nip|max:20',
            'nama' => 'required|string|max:100',
            'no_telp' => 'nullable|string|max:15'
        ]);

        Dosen::create($request->all());

        return redirect()->route('admin.dosen')->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function edit($id)
{
    $dosen = Dosen::findOrFail($id);
    return view('admin.akun-dosen.edit-dosen', compact('dosen')); // Perbaiki path view
}

public function update(Request $request, $id)
{
    $request->validate([
        'nip' => 'required|string|max:255',
        'nama' => 'required|string|max:255',
        'no_telp' => 'nullable|string|max:15',
    ]);

    $dosen = Dosen::findOrFail($id);
    $dosen->update([
        'nip' => $request->nip,
        'nama' => $request->nama,
        'no_telp' => $request->no_telp,
    ]);

    return redirect()->route('admin.dosen')->with('success', 'Data Dosen berhasil diperbarui!');
}
    // Menghapus data dosen
    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->delete();

        return redirect()->route('admin.dosen')->with('success', 'Dosen berhasil dihapus.');
    }
}
