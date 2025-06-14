<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Models\RubrikPenilaian;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RubrikPenilaianController extends Controller
{
    public function manage()
    {
        $aspek = RubrikPenilaian::orderByRaw("FIELD(jenis, 'softskill', 'akademik')")->get();
        return view('admin.rubrik.rubrik', compact('aspek'));
    }

    public function manageStore(Request $request)
    {
        $data = $request->input('rubrik', []);

        if (count($data) !== 19) {
            return redirect()->back()->with('error', 'Jumlah baris rubrik harus 19.');
        }

        $totalBobot = 0;
        foreach ($data as $row) {
            if (!isset($row['aspek_penilaian'], $row['jenis'], $row['bobot'])) {
                return redirect()->back()->with('error', 'Semua kolom harus diisi.');
            }

            if (!in_array($row['jenis'], ['softskill', 'akademik'])) {
                return redirect()->back()->with('error', 'Jenis penilaian tidak valid.');
            }

            if (!is_numeric($row['bobot']) || $row['bobot'] < 0 || $row['bobot'] > 25) {
                return redirect()->back()->with('error', 'Bobot harus antara 0 - 25.');
            }

            $totalBobot += (int)$row['bobot'];
        }

        if ($totalBobot > 100) {
            Alert::error('Gagal', 'Total bobot tidak boleh lebih dari 100%');
            return back()->withInput();
        }

        $existing = RubrikPenilaian::orderBy('jenis')->get();
        if ($existing->count() !== 19) {
            return redirect()->back()->with('error', 'Data rubrik di database tidak lengkap (harus 19 baris).');
        }

        foreach ($existing as $i => $rubrik) {
            $rubrik->update([
                'aspek_penilaian' => $data[$i]['aspek_penilaian'],
                'bobot' => $data[$i]['bobot'],
            ]);
        }

        Alert::success('Berhasil', 'Rubrik Penilaian berhasil disimpan.');
        return redirect()->route('admin.rubrik');
    }
}
