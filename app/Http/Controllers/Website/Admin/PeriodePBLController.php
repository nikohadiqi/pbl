<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodePBL;

class PeriodePBLController extends Controller
{
    public function index()
    {
        $periodePBL = PeriodePBL::all();
        return view('admin.periode-pbl.periodepbl', compact('periodePBL'));
    }

    public function create()
    {
        return view('admin.periode-pbl.tambah-periodepbl');
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|in:4,5',
            'tahun' => 'required|digits:4',
        ]);

        PeriodePBL::create($request->all());

        return redirect()->route('admin.periodepbl')->with('success', 'Periode PBL berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $periode = PeriodePBL::findOrFail($id);
        return view('admin.periode-pbl.edit-periodepbl', compact('periode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'semester' => 'required|in:4,5',
            'tahun' => 'required|digits:4',
        ]);

        $periode = PeriodePBL::findOrFail($id);
        $periode->update($request->all());

        return redirect()->route('admin.periodepbl')->with('success', 'Periode PBL berhasil diperbarui!');
    }

    public function destroy($id)
    {
        PeriodePBL::findOrFail($id)->delete();
        return redirect()->route('admin.periodepbl')->with('success', 'Periode PBL berhasil dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        PeriodePBL::whereIn('id', $request->ids)->delete();
        return redirect()->route('admin.periodepbl')->with('success', 'Periode PBL berhasil dihapus secara massal!');
    }
}
