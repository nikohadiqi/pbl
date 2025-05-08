<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PelaporanUAS;
use Illuminate\Support\Facades\Validator;

class PelaporanUASController extends Controller
{
    public function index()
    {
        return view('mahasiswa.semester4.pelaporan.form-laporan-uas');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'timpbl_id' => 'required|exists:timpbl,id',
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'keterangan' => 'nullable|string',
            'link_drive' => 'nullable|url',
            'link_youtube' => 'nullable|url',
            'laporan_pdf' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 400);
        }

        $pelaporan = PelaporanUAS::create($request->all());
        return response()->json(['success' => true, 'message' => 'UAS Report created successfully', 'data' => $pelaporan], 201);
    }

    public function destroy($id)
    {
        $pelaporan = PelaporanUAS::find($id);
        if (!$pelaporan) {
            return response()->json(['success' => false, 'message' => 'UAS Report not found'], 404);
        }
        $pelaporan->delete();
        return response()->json(['success' => true, 'message' => 'UAS Report deleted successfully'], 200);
    }
}
