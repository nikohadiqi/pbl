<?php

namespace App\Http\Controllers\API\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PelaporanUAS;
use Illuminate\Support\Facades\Validator;

class PelaporanUASController extends Controller
{
    public function index()
    {
        $pelaporans = PelaporanUAS::with(['mahasiswa', 'timPbl'])->get();
        return response()->json(['success' => true, 'message' => 'List of UAS Reports', 'data' => $pelaporans], 200);
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
