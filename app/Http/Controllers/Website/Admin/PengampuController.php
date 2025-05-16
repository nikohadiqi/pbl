<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkunDosen;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\Pengampu;
use App\Models\PeriodePBL;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PengampuController extends Controller
{
    public function index()
    {
        $pengampus = Pengampu::with(['kelasFk', 'dosenFk', 'matkulFK', 'periodeFK'])->get();
        return view('admin.pengampu.pengampu', compact('pengampus'));
    }

    /**
     * Menampilkan halaman tambah
     */
    public function create()
    {
        $kelas = Kelas::all();
        $dosen = Dosen::all();
        $matkuls = MataKuliah::all();
        $periodes = PeriodePBL::all();
        return view('admin.pengampu.tambah-pengampu', compact('kelas', 'dosen', 'matkuls', 'periodes'));
    }

    /**
     * Proses tambah Tim PBL
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'dosen_id' => 'required',
            'status' => 'required|in:Manajer Proyek,Dosen Mata Kuliah',
            'matkul_id' => 'required',
            'periode_id' => 'required',
        ]);

        Pengampu::create($request->all());

        // Ambil data dosen berdasarkan dosen_id
        $dosen = Dosen::findOrFail($request->dosen_id);

        // Cek apakah akun dosen dengan nim (berdasarkan nip) sudah ada
        $existingAkun = AkunDosen::where('nim', $dosen->nip)->first();

        if (!$existingAkun) {
            // Jika belum ada, buat akun baru
            AkunDosen::create([
                'role' => 'dosen',
                'nim' => $dosen->nip,
                'password' => bcrypt($dosen->nip), // Enkripsi password
            ]);
        }

        Alert::success('Berhasil!', 'Data Pengampu & Akun Dosen Pengampu berhasil ditambahkan!');
        return redirect()->route('admin.pengampu');
    }


    /**
     * Menampilkan halaman edit
     */
    public function edit($id)
    {
        $pengampu = Pengampu::findOrFail($id);
        $kelas = Kelas::all();
        $dosen = Dosen::all();
        $matkuls = MataKuliah::all();
        $periodes = PeriodePBL::all();
        return view('admin.pengampu.edit-pengampu', compact('pengampu', 'kelas', 'dosen', 'matkuls', 'periodes'));
    }

    /**
     * Proses perbarui
     */
    public function update(Request $request, $id)
    {
        $pengampu = Pengampu::findOrFail($id);

        $request->validate([
            'kelas_id' => 'required',
            'dosen_id' => 'required',
            'status' => 'required|in:Manajer Proyek,Dosen Mata Kuliah',
            'matkul_id' => 'required',
            'periode_id' => 'required',
        ]);

        $pengampu->update($request->all());

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Pengampu Berhasil Diperbarui!');

        return redirect()->route('admin.pengampu');
    }


    /**
     * Hapus
     */
    public function destroy($id)
    {
        $pengampu = Pengampu::findOrFail($id);
        $pengampu->delete();
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Pengampu Berhasil Dihapus!');

        return redirect()->route('admin.pengampu');
    }

    // Search Manpro
    public function searchManpro(Request $request)
    {
        $search = $request->q;
        $data = Pengampu::where('status', 'Manajer Proyek')
            ->whereHas('dosenFk', function ($query) use ($search) {
                $query->where('nama', 'like', "%$search%")
                    ->orWhere('nip', 'like', "%$search%");
            })
            ->with('dosenFk')
            ->limit(10)
            ->get();

        return response()->json($data->map(function ($item) {
            return ['id' => $item->dosenFk->nip, 'text' => $item->dosenFk->nip . ' - ' . $item->dosenFk->nama];
        }));
    }
}
