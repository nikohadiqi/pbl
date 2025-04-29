<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\PeriodePBL;
use App\Models\TimPBL;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class TimPBLController extends Controller
{
    /**
     * Menampilkan daftar Tim PBL
     */
    public function index()
    {
        $timPBL = TimPBL::all();
        $ketuaTim = Mahasiswa::all();
        $periode = PeriodePBL::all();
        return view('admin.tim-pbl.timpbl', compact('timPBL', 'ketuaTim', 'periode'));
    }

    /**
     * Menampilkan halaman tambah Tim PBL
     */
    public function create()
    {
        $periode = PeriodePBL::all();
        $ketuaTim = Mahasiswa::all();
        return view('admin.tim-pbl.tambah-timpbl', compact('periode', 'ketuaTim')); // Pastikan file view ini ada di folder views/admin/tim-pbl/
    }

    /**
     * Proses tambah Tim PBL
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tim' => 'required|unique:timpbl,id_tim',
            'ketua_tim' => 'required|exists:mahasiswa,nim',
            'periode_id' => 'required',
        ]);
    
        // Simpan TimPBL
        TimPBL::create([
            'id_tim' => $request->id_tim,
            'ketua_tim' => $request->ketua_tim,
            'periode_id' => $request->periode_id,
        ]);
    
        // Cek apakah user dengan nim ini sudah ada
        $existingUser = User::where('nim', $request->ketua_tim)->first();
    
        if (!$existingUser) {
            // Buat akun baru untuk mahasiswa
            User::create([
                'nim' => $request->ketua_tim,
                'password' => Hash::make($request->ketua_tim), // password = nim
                'role' => 'mahasiswa',
            ]);
        }
    
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Tim dan User Mahasiswa berhasil Ditambahkan!');
    
        return redirect()->route('admin.timpbl');
    }
    

    /**
     * Menampilkan halaman edit Tim PBL
     */
    public function edit($id_tim)
    {
        $timPBL = TimPBL::findOrFail($id_tim);
        $periode = PeriodePBL::all();
        $ketuaTim = Mahasiswa::all();
        return view('admin.tim-pbl.edit-timpbl', compact('timPBL', 'periode', 'ketuaTim')); // Pastikan path view sesuai dengan file yang ada
    }

    /**
     * Proses perbarui Tim PBL
     */
    public function update(Request $request, $id_tim)
    {
        $request->validate([
            'id_tim' => 'required|unique:timpbl,id_tim,' . $id_tim . ',id_tim',
            'ketua_tim' => 'required|exists:mahasiswa,nim',
            'periode_id' => 'required',
        ]);

        $timPBL = TimPBL::findOrFail($id_tim);

        $timPBL->update([
            'id_tim' => $request->id_tim,
            'ketua_tim' => $request->ketua_tim,
            'periode_id' => $request->periode_id,
        ]);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Tim berhasil Diperbarui!');

        return redirect()->route('admin.timpbl');
    }


    /**
     * Hapus Tim PBL
     */
    public function destroy($id_tim)
    {
        $timPBL = TimPBL::findOrFail($id_tim);
        $timPBL->delete();
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Data Tim PBL berhasil dihapus!');
        return redirect()->route('admin.timpbl');
    }

    public function cariKetua(Request $request)
    {
        $nim = $request->query('nim');
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if ($mahasiswa) {
            return response()->json([
                'success' => true,
                'nim' => $mahasiswa->nim,
                'nama' => $mahasiswa->nama,
                'kelas' => $mahasiswa->kelas,
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
