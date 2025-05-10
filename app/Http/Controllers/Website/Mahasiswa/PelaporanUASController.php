<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PelaporanUAS;
use App\Models\Anggota_Tim_Pbl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PelaporanUASController extends Controller
{
    public function index()
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Anda belum tergabung dalam tim PBL.');
        }

        $kode_tim = $anggota->kode_tim;
        // Check if the student already has a report
        $laporan = PelaporanUAS::where('kode_tim', $kode_tim)->first();

        return view('mahasiswa.semester4.pelaporan.form-laporan-uas', compact('kode_tim', 'laporan'));
    }

    public function store(Request $request)
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

        if (!$anggota) {
            return response()->json(['success' => false, 'message' => 'Tidak ditemukan tim untuk mahasiswa ini.'], 400);
        }

        $request->merge(['kode_tim' => $anggota->kode_tim]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'keterangan' => 'nullable|string',
            'link_drive' => 'nullable|string',
            'link_youtube' => 'nullable|string',
            'laporan_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'kode_tim' => 'required|string|exists:tim_pbl,kode_tim'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Check if the report already exists
        $laporan = PelaporanUAS::where('kode_tim', $anggota->kode_tim)->first();

        // If the report exists, update it; otherwise, create a new one
        if ($laporan) {
            $laporan->update([
                'keterangan' => $request->keterangan,
                'link_drive' => $request->link_drive,
                'link_youtube' => $request->link_youtube,
                'kode_tim' => $request->kode_tim,
            ]);
            // Update the file if it is uploaded
            if ($request->hasFile('laporan_pdf')) {
                $file = $request->file('laporan_pdf');
                $filePath = $file->store('laporan_pbl', 'public');
                $laporan->update(['laporan_pdf' => $filePath]);
            }
        } else {
            // Create new report
            $filePath = null;
            if ($request->hasFile('laporan_pdf')) {
                $file = $request->file('laporan_pdf');
                $filePath = $file->store('laporan_pbl', 'public');
            }
            
            $laporan = PelaporanUAS::create([
                'keterangan' => $request->keterangan,
                'link_drive' => $request->link_drive,
                'link_youtube' => $request->link_youtube,
                'laporan_pdf' => $filePath,
                'kode_tim' => $request->kode_tim,
            ]);
        }

        return redirect()->route('mahasiswa.pelaporan-pbl.laporan-uas')->with([
            'success' => 'Laporan UAS berhasil disimpan!',
            'laporan' => $laporan,
        ]);
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
