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
    // Search Manpro
    public function searchManpro(Request $request)
    {
        $search = $request->q;

        // Ambil periode yang sedang aktif
        $periodeAktif = PeriodePBL::where('status', 'Aktif')->first();

        if (!$periodeAktif) {
            return response()->json([]); // Tidak ada periode aktif, kembalikan kosong
        }

        // Cari dosen pengampu Manajer Proyek pada periode aktif
        $data = Pengampu::where('status', 'Manajer Proyek')
            ->where('periode_id', $periodeAktif->id)
            ->whereHas('dosenFk', function ($query) use ($search) {
                $query->where('nama', 'like', "%$search%")
                    ->orWhere('nip', 'like', "%$search%");
            })
            ->with('dosenFk')
            ->limit(10)
            ->get();

        // Format response JSON
        return response()->json($data->map(function ($item) {
            return [
                'id' => $item->dosenFk->nip,
                'text' => $item->dosenFk->nip . ' - ' . $item->dosenFk->nama
            ];
        }));
    }

    public function manage(Request $request)
    {
        $kelas = Kelas::all();
        $periodes = PeriodePBL::where('status', 'Aktif')->get();
        $dosen = Dosen::all();
        $matkuls = MataKuliah::all();

        // Ambil dari session jika tidak ada request baru
        $selectedKelas = $request->input('kelas', session('filter_kelas'));
        $selectedPeriode = $request->input('periode_id', session('filter_periode'));

        // Simpan ke session jika ada input baru
        if ($request->filled('kelas')) {
            session(['filter_kelas' => $selectedKelas]);
        }
        if ($request->filled('periode_id')) {
            session(['filter_periode' => $selectedPeriode]);
        }

        $pengampus = collect();
        if ($selectedKelas && $selectedPeriode) {
            $pengampus = Pengampu::where('kelas_id', $selectedKelas)
                ->where('periode_id', $selectedPeriode)
                ->get()
                ->keyBy('matkul_id');
        }

        return view('admin.pengampu.pengampu', compact('kelas', 'periodes', 'dosen', 'matkuls', 'pengampus', 'selectedKelas', 'selectedPeriode'));
    }

    public function manageStore(Request $request)
    {
        $kelasId = $request->input('kelas_id');
        $periodeId = $request->input('periode_id');
        $data = $request->input('data'); // format: ['matkul_id' => ['dosen_id' => ..., 'status' => ...]]

        // Ambil semua pengampu yang sudah ada untuk periode dan kelas tersebut
        $existing = Pengampu::where('kelas_id', $kelasId)
            ->where('periode_id', $periodeId)
            ->get();

        // Validasi: satu dosen hanya bisa mengampu satu matkul di kelas dan periode yang sama
        $dosenDipakai = [];
        foreach ($data as $matkulId => $pengampuData) {
            $dosenId = $pengampuData['dosen_id'];
            if (in_array($dosenId, $dosenDipakai)) {
                Alert::error('Gagal', 'Satu dosen hanya boleh mengampu satu mata kuliah untuk kelas dan periode yang sama.');
                session()->flash('filter_kelas', $kelasId);
                session()->flash('filter_periode', $periodeId);
                return redirect()->back()->withInput();
            }
            $dosenDipakai[] = $dosenId;
        }

        // Simpan/update data
        foreach ($data as $matkulId => $pengampuData) {
            $pengampu = Pengampu::updateOrCreate(
                [
                    'kelas_id' => $kelasId,
                    'periode_id' => $periodeId,
                    'matkul_id' => $matkulId,
                ],
                [
                    'dosen_id' => $pengampuData['dosen_id'],
                    'status' => $pengampuData['status'],
                ]
            );

            // Buat akun dosen jika belum ada
            $dosen = Dosen::find($pengampuData['dosen_id']);
            if ($dosen && !AkunDosen::where('nim', $dosen->nip)->exists()) {
                AkunDosen::create([
                    'role' => 'dosen',
                    'nim' => $dosen->nip,
                    'password' => bcrypt($dosen->nip),
                ]);
            }
        }

        Alert::success('Berhasil', 'Data Pengampu berhasil disimpan!');
        return redirect()->route('admin.pengampu');
    }
}
