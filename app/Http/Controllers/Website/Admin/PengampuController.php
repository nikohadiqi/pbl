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
        $kelas = $request->kelas;
        $periodeId = $request->periode_id;

        $pengampu = Pengampu::where('status', 'Manajer Proyek')
            ->where('kelas_id', $kelas)
            ->where('periode_id', $periodeId)
            ->with('dosenFk')
            ->first();

        if ($pengampu && $pengampu->dosenFk) {
            return response()->json([
                'nip' => $pengampu->dosenFk->nip,
                'nama' => $pengampu->dosenFk->nama,
            ]);
        }

        return response()->json([], 404);
    }

    public function manage(Request $request)
    {
        $kelas = Kelas::all();
        $periodes = PeriodePBL::where('status', 'Aktif')->get();
        $dosen = Dosen::all();

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

        // Filter matkul berdasarkan periode yang dipilih
        $matkuls = collect();
        if ($selectedPeriode) {
            $matkuls = MataKuliah::where('periode_id', $selectedPeriode)->get();
        }

        // Ambil pengampu jika ada kelas dan periode dipilih
        $pengampus = collect();
        if ($selectedKelas && $selectedPeriode) {
            $pengampus = Pengampu::where('kelas_id', $selectedKelas)
                ->where('periode_id', $selectedPeriode)
                ->get()
                ->keyBy('matkul_id');
        }

        return view('admin.pengampu.pengampu', compact(
            'kelas',
            'periodes',
            'dosen',
            'matkuls',
            'pengampus',
            'selectedKelas',
            'selectedPeriode'
        ));
    }

    public function manageStore(Request $request)
    {
        $kelasId = $request->input('kelas_id');
        $periodeId = $request->input('periode_id');
        $data = $request->input('data'); // format: ['matkul_id' => ['dosen_id' => ..., 'status' => ...]]

        // Validasi: satu dosen hanya boleh mengampu satu matkul di kelas dan periode yang sama
        $dosenDipakai = [];
        $jumlahManpro = 0;

        foreach ($data as $matkulId => $pengampuData) {
            $dosenId = $pengampuData['dosen_id'];
            $status = $pengampuData['status'];

            if (in_array($dosenId, $dosenDipakai)) {
                Alert::error('Gagal', 'Satu dosen hanya boleh mengampu satu mata kuliah untuk kelas dan periode yang sama.');
                session(['filter_kelas' => $kelasId]);
                session(['filter_periode' => $periodeId]);
                return redirect()->back()->withInput();
            }

            $dosenDipakai[] = $dosenId;

            // CEK: apakah dosen ini sudah menjadi manpro di kelas lain pada periode yang sama
            if ($status === 'Manajer Proyek') {
                $jumlahManpro++;

                $pengampuLain = Pengampu::where('periode_id', $periodeId)
                    ->where('status', 'Manajer Proyek')
                    ->where('dosen_id', $dosenId)
                    ->where('kelas_id', '!=', $kelasId)
                    ->with('kelasFK') // load relasi kelas
                    ->first();

                if ($pengampuLain) {
                    $namaDosen = Dosen::find($dosenId)->nama ?? 'Dosen';
                    $namaKelas = $pengampuLain->kelasFK->kelas ?? 'kelas lain';

                    Alert::error('Gagal', "Dosen $namaDosen sudah menjadi Manajer Proyek di Kelas $namaKelas pada periode ini.");
                    session(['filter_kelas' => $kelasId]);
                    session(['filter_periode' => $periodeId]);
                    return redirect()->back()->withInput();
                }
            }
        }

        // Validasi hanya boleh ada satu Manajer Proyek
        if ($jumlahManpro > 1) {
            Alert::error('Gagal', 'Dalam satu kelas hanya boleh ada satu Manajer Proyek.');
            session(['filter_kelas' => $kelasId]);
            session(['filter_periode' => $periodeId]);
            return redirect()->back()->withInput();
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
