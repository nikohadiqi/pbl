<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Anggota_Tim_Pbl;
use App\Models\PelaporanUTS;
use App\Models\PelaporanUAS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PelaporanController extends Controller
{
    public function index()
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Anda belum tergabung dalam tim PBL.');
        }

        $kode_tim = $anggota->kode_tim;

        // Ambil data laporan UTS dan UAS berdasarkan kode_tim jika ada
        $pelaporanUTS = PelaporanUTS::where('kode_tim', $kode_tim)->first();
        $pelaporanUAS = PelaporanUAS::where('kode_tim', $kode_tim)->first();

        return view('mahasiswa.pelaporan.pelaporan-pbl', compact('kode_tim', 'pelaporanUTS', 'pelaporanUAS'));
    }

    public function storeUTS(Request $request)
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

        $validator = Validator::make($request->all(), [
            'keterangan' => 'required|string',
            'link_drive' => 'required|url',
            'link_youtube' => 'nullable|url',
            'laporan_pdf' => 'nullable|file|mimes:pdf|max:10240', // max 10MB
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

        Alert::success('Berhasil!', 'Laporan UTS berhasil disimpan!');
        return redirect()->route('mahasiswa.pelaporan-pbl');
    }

    public function storeUAS(Request $request)
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $anggota = Anggota_Tim_Pbl::where('nim', $nim)->first();

        $validator = Validator::make($request->all(), [
            'keterangan' => 'required|string',
            'link_drive' => 'required|url',
            'link_youtube' => 'nullable|url',
            'laporan_pdf' => 'nullable|file|mimes:pdf|max:10240', // max 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kode_tim = $request->kode_tim;

        $pelaporan = PelaporanUAS::where('kode_tim', $kode_tim)->first();

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

            $pelaporan = PelaporanUAS::create([
                'kode_tim' => $kode_tim,
                'keterangan' => $request->keterangan,
                'link_drive' => $request->link_drive,
                'link_youtube' => $request->link_youtube,
                'laporan_pdf' => $filePath,
            ]);
        }

        Alert::success('Berhasil!', 'Laporan UAS berhasil disimpan!');
        return redirect()->route('mahasiswa.pelaporan-pbl');
    }
}
