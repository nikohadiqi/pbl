<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\PeriodePBL;
use RealRashid\SweetAlert\Facades\Alert;

class MataKuliahController extends Controller
{
    public function manage(Request $request)
    {
        $periodes = PeriodePBL::where('status', 'Aktif')->get();
        // Ambil dari session jika tidak ada request baru
        $selectedPeriodeId = $request->input('periode_id', session('filter_periode'));

        // Simpan ke session jika ada input baru
        if ($request->filled('periode_id')) {
            session(['filter_periode' => $selectedPeriodeId]);
        }
        $mataKuliahList = [];

        if ($selectedPeriodeId) {
            $mataKuliahList = MataKuliah::where('periode_id', $selectedPeriodeId)->get();
        }

        return view('admin.mata-kuliah.matkul', compact('periodes', 'selectedPeriodeId', 'mataKuliahList'));
    }

    public function manageStore(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodepbl,id',
            'id.*' => 'nullable|integer|exists:matakuliah,id',
            'kode.*' => 'required|string|size:8|unique:matakuliah,kode',
            'matakuliah.*' => 'required|string',
            'sks.*' => 'nullable|integer',
        ], [
            'kode.*' => 'Kode Mata Kuliah tidak boleh sama.',
        ]);

        $periodeId = $request->periode_id;
        $programStudi = 'Teknologi Rekayasa Perangkat Lunak';

        // Ambil semua ID mata kuliah lama untuk periode ini
        $existingIds = MataKuliah::where('periode_id', $periodeId)->pluck('id')->toArray();

        $idsFromForm = array_filter($request->id); // ambil yg ada id-nya

        // Hapus mata kuliah yang tidak ada di form
        $toDelete = array_diff($existingIds, $idsFromForm);
        if (!empty($toDelete)) {
            MataKuliah::whereIn('id', $toDelete)->delete();
        }

        foreach ($request->kode as $index => $kode) {
            $data = [
                'kode' => trim($kode),
                'matakuliah' => $request->matakuliah[$index],
                'sks' => $request->sks[$index] ?? null,
                'program_studi' => $programStudi,
                'periode_id' => $periodeId,
            ];

            $id = $request->id[$index] ?? null;
            if ($id && in_array($id, $existingIds)) {
                MataKuliah::where('id', $id)->update($data);
            } else {
                MataKuliah::create($data);
            }
        }

        Alert::success('Berhasil!', 'Data Mata Kuliah berhasil disimpan!');
        return redirect()->route('admin.matkul', ['periode_id' => $periodeId]);
    }
}
