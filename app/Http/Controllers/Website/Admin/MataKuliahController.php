<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\PeriodePBL;
use Illuminate\Support\Facades\Validator;
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
        $rules = [
            'periode_id' => 'required|exists:periodepbl,id',
            'id.*' => 'nullable|integer|exists:matakuliah,id',
            'kode.*' => 'required|string|size:8',
            'matakuliah.*' => 'required|string',
            'sks.*' => 'nullable|integer',
        ];

        $messages = [
            'kode.*.required' => 'Kode Mata Kuliah harus diisi.',
            'kode.*.size' => 'Kode Mata Kuliah harus terdiri dari 8 karakter.',
            'matakuliah.*.required' => 'Nama Mata Kuliah harus diisi.',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        // Validasi kode unik manual, abaikan jika id sama
        foreach ($request->kode as $i => $kode) {
            $existing = MataKuliah::where('kode', $kode);

            if (!empty($request->id[$i])) {
                $existing->where('id', '!=', $request->id[$i]); // abaikan jika kode milik record yg sama
            }

            if ($existing->exists()) {
                return back()->withErrors(['kode.' . $i => 'Kode Mata Kuliah tidak boleh sama.'])->withInput();
            }
        }

        // Simpan data
        $periodeId = $request->periode_id;
        $programStudi = 'Teknologi Rekayasa Perangkat Lunak';

        $existingIds = MataKuliah::where('periode_id', $periodeId)->pluck('id')->toArray();
        $idsFromForm = array_filter($request->id);
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
