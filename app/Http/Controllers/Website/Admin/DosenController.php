<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Imports\DosenImport;
use Illuminate\Http\Request;
use App\Models\Dosen;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class DosenController extends Controller
{
    // Menampilkan daftar dosen
    public function index()
    {
        $dosen = Dosen::all();
        return view('admin.dosen.dosen', compact('dosen'));
    }

    // Menampilkan form tambah dosen
    public function create()
    {
        return view('admin.dosen.tambah-dosen');
    }

    // Menyimpan data dosen
    public function store(Request $request)
    {
        $request->validate([
            'nip'            => 'required|unique:dosen,nip|max:50',
            'nama'           => 'required|string|max:100',
            'no_telp'        => 'required|string|max:15',
            'email'          => 'required|email',
            'prodi'          => 'required|string|max:100',
            'jurusan'        => 'required|string|max:100',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'status_dosen'   => 'nullable|string|max:50',
        ]);

        Dosen::create($request->all());

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Dosen berhasil Ditambahkan!');
        return redirect()->route('admin.dosen');
    }

    public function edit($nip)
    {
        $dosen = Dosen::findOrFail($nip);
        return view('admin.dosen.edit-dosen', compact('dosen')); // Perbaiki path view
    }

    public function update(Request $request, $nip)
    {
        $dosen = Dosen::findOrFail($nip);

        $request->validate([
            'nip'            => 'required|string|max:50|unique:dosen,nip,' . $nip . ',nip',
            'nama'           => 'required|string|max:100',
            'no_telp'        => 'required|string|max:15',
            'email'          => 'required|email',
            'prodi'          => 'required|string|max:100',
            'jurusan'        => 'required|string|max:100',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'status_dosen'   => 'nullable|string|max:50',
        ]);

        $dosen->update($request->all());

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Dosen berhasil Diperbarui!');
        return redirect()->route('admin.dosen');
    }
    // Menghapus data dosen
    public function destroy($nip)
    {
        $dosen = Dosen::findOrFail($nip);
        $dosen->delete();

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Dosen berhasil Dihapus!');
        return redirect()->route('admin.dosen');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new DosenImport, $request->file('file'));

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Dosen Berhasil Diimpor!');

        return redirect()->route('admin.dosen');
    }
}
