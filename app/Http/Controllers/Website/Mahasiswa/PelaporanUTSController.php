<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Anggota_Tim_Pbl;
use Illuminate\Http\Request;
use App\Models\PelaporanUTS;
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
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $kode_tim = $request->kode_tim;

    $pelaporan = PelaporanUTS::where('kode_tim', $kode_tim)->first();

    if ($pelaporan) {
        // Update existing
        $pelaporan->keterangan = $request->keterangan;
        $pelaporan->link_drive = $request->link_drive;
        $pelaporan->link_youtube = $request->link_youtube;

        if ($request->hasFile('laporan_pdf')) {
            $file = $request->file('laporan_pdf');
            $filePath = $file->store('laporan_pbl', 'public');
            $pelaporan->laporan_pdf = $filePath;
        }

        $pelaporan->save();
    } else {
        // Create new
        $filePath = null;
        if ($request->hasFile('laporan_pdf')) {
            $file = $request->file('laporan_pdf');
            $filePath = $file->store('laporan_pbl', 'public');
        }

        $pelaporan = PelaporanUTS::create([
            'kode_tim' => $kode_tim,
            'keterangan' => $request->keterangan,
            'link_drive' => $request->link_drive,
            'link_youtube' => $request->link_youtube,
            'laporan_pdf' => $filePath,
        ]);
    }

    return redirect()->route('mahasiswa.pelaporan-pbl.laporan-uts')->with('success', 'Laporan UTS berhasil disimpan!');
}

}
