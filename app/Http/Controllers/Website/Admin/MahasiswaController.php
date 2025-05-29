<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MahasiswaImport;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaController extends Controller
{
    // Menampilkan daftar mahasiswa
    public function index()
    {
        $mahasiswa = Mahasiswa::orderBy('kelas', 'asc')
                      ->orderBy('nama', 'asc')
                      ->get();

        $kelas = Kelas::all();

        return view('admin.mahasiswa.mahasiswa', compact('mahasiswa', 'kelas'));
    }

    // Menampilkan form tambah mahasiswa
    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.mahasiswa.tambah-mahasiswa', compact('kelas'));
    }

    // Menyimpan data mahasiswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:15|unique:data_mahasiswa,nim',
            'nama' => 'required|string|max:100',
            'kelas' => 'required',
            'program_studi' => 'required',
            'status' => 'nullable',
            'dosen_wali' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'angkatan' => 'nullable',
        ]);

        Mahasiswa::create($request->all());

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data mahasiswa berhasil Ditambahkan!');

        return redirect()->route('admin.mahasiswa');
    }

    // Menampilkan form edit mahasiswa
    public function edit($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $kelas = Kelas::all();
        return view('admin.mahasiswa.edit-mahasiswa', compact('mahasiswa', 'kelas'));
    }

    // Memperbarui data mahasiswa
    public function update(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);

        $request->validate([
            'nim' => 'required|string|max:15|unique:data_mahasiswa,nim,' . $nim . ',nim',
            'nama' => 'required|string|max:100',
            'kelas' => 'required',
            'program_studi' => 'required',
            'status' => 'nullable',
            'dosen_wali' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'angkatan' => 'nullable',
        ]);

        $mahasiswa->update($request->all());

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data mahasiswa berhasil diperbarui!');

        return redirect()->route('admin.mahasiswa');
    }

    public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $mahasiswa->delete();

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data mahasiswa berhasil Dihapus!');

        return redirect()->route('admin.mahasiswa');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        try {
            Excel::import(new MahasiswaImport, $request->file('file'));

            Alert::success('Berhasil!', 'Data Mahasiswa Berhasil Diimpor!');
            return redirect()->route('admin.mahasiswa');
        } catch (ValidationException $e) {
            Alert::error('Format Salah!', $e->validator->errors()->first());
            return back();
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat impor. Pastikan format file sesuai.');
            return back();
        }
    }

    // search mahasiswa
    public function searchMahasiswa(Request $request)
    {
        $search = $request->q;
        $kelas = $request->kelas;

        $data = Mahasiswa::where('kelas', $kelas)
            ->where(function ($query) use ($search) {
                $query->where('nim', 'like', "%$search%")
                    ->orWhere('nama', 'like', "%$search%");
            })
            ->limit(10)
            ->get();

        return response()->json($data->map(function ($item) {
            return ['id' => $item->nim, 'text' => $item->nim . ' - ' . $item->nama];
        }));
    }

}
