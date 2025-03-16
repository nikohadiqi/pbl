<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PelaporanUTS;
use Illuminate\Support\Facades\Validator;

class PelaporanUTSController extends Controller
{
    public function index()
    {
        $pelaporans = PelaporanUTS::with(['mahasiswa', 'timPbl'])->get();
        return response()->json(['success' => true, 'message' => 'List of UTS Reports', 'data' => $pelaporans], 200);
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

        $pelaporan = PelaporanUTS::create($request->all());
        return response()->json(['success' => true, 'message' => 'UTS Report created successfully', 'data' => $pelaporan], 201);
    }

    public function destroy($id)
    {
        $pelaporan = PelaporanUTS::find($id);
        if (!$pelaporan) {
            return response()->json(['success' => false, 'message' => 'UTS Report not found'], 404);
        }
        $pelaporan->delete();
        return response()->json(['success' => true, 'message' => 'UTS Report deleted successfully'], 200);
    }
}
