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
        $periode = PeriodePBL::where('status', 'aktif')->firstOrFail(); // Periode aktif otomatis

        $semesterList = semesterDariKategori($periode->kategori_semester);
        $selectedSemester = $request->semester ?? $semesterList[0]; // default semester pertama dari list

        $matakuliahs = MataKuliah::where('periode_id', $periode->id)
            ->where('semester', $selectedSemester)
            ->get();

        return view('admin.mata-kuliah.matkul', compact(
            'periode',
            'semesterList',
            'selectedSemester',
            'matakuliahs'
        ));
    }

    public function manageStore(Request $request)
    {
        $rules = [
            'periode_id' => 'required|exists:periodepbl,id',
            'semester' => 'required|in:1,2,3,4,5,6',
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
        $semester = $request->semester;
        $programStudi = 'Teknologi Rekayasa Perangkat Lunak';

        $existingIds = MataKuliah::where('periode_id', $periodeId)
                    ->where('semester', $semester)
                    ->pluck('id')->toArray();

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
                'semester' => $semester,
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
        return redirect()->route('admin.matkul', [
            'periode_id' => $periodeId,
            'semester' => $semester
        ]);
    }
}
