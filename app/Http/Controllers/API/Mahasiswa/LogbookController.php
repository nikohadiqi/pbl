<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logbook;
use Illuminate\Support\Facades\Validator;

class LogbookController extends Controller
{
    public function index()
    {
        $logbooks = Logbook::with(['mahasiswa', 'timPbl'])->get();
        return response()->json([
            'success' => true,
            'message' => 'List of Logbooks',
            'data' => $logbooks
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'timpbl_id' => 'required|exists:timpbl,id',
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'aktivitas' => 'nullable|string',
            'hasil' => 'nullable|string',
            'foto_kegiatan' => 'nullable|string',
            'anggota1' => 'nullable|string',
            'anggota2' => 'nullable|string',
            'anggota3' => 'nullable|string',
            'anggota4' => 'nullable|string',
            'anggota5' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        $logbook = Logbook::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Logbook created successfully',
            'data' => $logbook
        ], 201);
    }

    public function show($id)
    {
        $logbook = Logbook::with(['mahasiswa', 'timPbl'])->find($id);

        if (!$logbook) {
            return response()->json([
                'success' => false,
                'message' => 'Logbook not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logbook details',
            'data' => $logbook
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $logbook = Logbook::find($id);

        if (!$logbook) {
            return response()->json([
                'success' => false,
                'message' => 'Logbook not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'aktivitas' => 'nullable|string',
            'hasil' => 'nullable|string',
            'foto_kegiatan' => 'nullable|string',
            'anggota1' => 'nullable|string',
            'anggota2' => 'nullable|string',
            'anggota3' => 'nullable|string',
            'anggota4' => 'nullable|string',
            'anggota5' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        $logbook->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Logbook updated successfully',
            'data' => $logbook
        ], 200);
    }

    public function destroy($id)
    {
        $logbook = Logbook::find($id);

        if (!$logbook) {
            return response()->json([
                'success' => false,
                'message' => 'Logbook not found'
            ], 404);
        }

        $logbook->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logbook deleted successfully'
        ], 200);
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:logbook,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        Logbook::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected logbooks deleted successfully'
        ], 200);
    }
}
