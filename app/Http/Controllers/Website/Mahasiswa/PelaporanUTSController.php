<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PelaporanUTS;
use App\Models\Anggota_Tim_Pbl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PelaporanUTSController extends Controller
{
    public function index()
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Anda belum tergabung dalam tim PBL.');
        }

        $kode_tim = $anggota->kode_tim;
        // Check if the student already has a UTS report
        $pelaporan = PelaporanUTS::where('kode_tim', $kode_tim)->first();

        return view('mahasiswa.semester4.pelaporan.form-laporan-uts', compact('pelaporan', 'kode_tim'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keterangan' => 'nullable|string',
            'link_drive' => 'nullable|string',
            'link_youtube' => 'nullable|string',
            'laporan_pdf' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 400);
        }

        // Check if an UTS report exists for this team, if yes, update it
        $pelaporan = PelaporanUTS::firstOrNew(['kode_tim' => $request->kode_tim]);

        if ($pelaporan) {
            $pelaporan->update([
                'keterangan' => $request->keterangan,
                'link_drive' => $request->link_drive,
                'link_youtube' => $request->link_youtube,
                'kode_tim' => $request->kode_tim,
            ]);
            // Update the file if it is uploaded
            if ($request->hasFile('laporan_pdf')) {
                $file = $request->file('laporan_pdf');
                $filePath = $file->store('laporan_pbl', 'public');
                $pelaporan->update(['laporan_pdf' => $filePath]);
            }
        } else {
            // Create new report
            $filePath = null;
            if ($request->hasFile('laporan_pdf')) {
                $file = $request->file('laporan_pdf');
                $filePath = $file->store('laporan_pbl', 'public');
            }
            
            $pelaporan = PelaporanUTS::create([
                'keterangan' => $request->keterangan,
                'link_drive' => $request->link_drive,
                'link_youtube' => $request->link_youtube,
                'laporan_pdf' => $filePath,
                'kode_tim' => $request->kode_tim,
            ]);
        }

        return redirect()->route('mahasiswa.pelaporan-pbl.laporan-uts')->with([
            'success' => 'Laporan UTS berhasil disimpan!',
            'laporan' => $pelaporan,
        ]);
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
