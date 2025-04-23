<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\TimPBL;

class TimPBLController extends Controller
{
    /**
     * Menampilkan daftar Tim PBL
     */
    public function index()
    {
        $timPBL = TimPBL::with('ketua')->paginate(10); // Gunakan paginate() agar pagination bisa muncul
        return view('admin.tim-pbl.timpbl', compact('timPBL'));
    }

    /**
     * Menampilkan halaman tambah Tim PBL
     */
    public function create()
    {
        return view('admin.tim-pbl.tambah-timpbl'); // Pastikan file view ini ada di folder views/admin/tim-pbl/
    }

    /**
     * Proses tambah Tim PBL
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tim' => 'required|unique:timpbl,id_tim',
            'kode_tim' => 'required', // Pastikan kode_tim diisi
            'ketua_nim' => 'required|exists:mahasiswa,nim',
        ]);
    
        TimPBL::create([
            'id_tim' => $request->id_tim,
            'kode_tim' => $request->kode_tim, // Menambahkan kode_tim
            'ketua_nim' => $request->ketua_nim,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('admin.timpbl')->with('success', 'Tim PBL berhasil ditambahkan.');
    }
    
    /**
     * Menampilkan halaman edit Tim PBL
     */
    public function edit($id)
    {
        $timPBL = TimPBL::findOrFail($id);
        return view('admin.tim-pbl.edit-timpbl', compact('timPBL')); // Pastikan path view sesuai dengan file yang ada
    }

    /**
     * Proses perbarui Tim PBL
     */
    public function update(Request $request, $id)
    {
        $timPBL = TimPBL::findOrFail($id);

        $request->validate([
            'kelas' => 'sometimes|string',
            'code_tim' => 'sometimes|string',
            'ketua_tim_nim' => 'sometimes|string|exists:mahasiswa,nim',
        ]);

        if ($request->has('ketua_tim_nim')) {
            $ketuaTim = Mahasiswa::where('nim', $request->ketua_tim_nim)->firstOrFail();
            $timPBL->ketua_tim = $ketuaTim->id;
        }

        $timPBL->update($request->except('ketua_tim_nim'));

        return redirect()->route('admin.timpbl')->with('success', 'Tim PBL berhasil diperbarui!');
    }

    /**
     * Hapus Tim PBL
     */
    public function destroy($id)
    {
        $timPBL = TimPBL::findOrFail($id);
        $timPBL->delete();
        return redirect()->route('admin.timpbl')->with('success', 'Tim PBL berhasil dihapus!');
    }

}
