<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AnggotaTimPbl;
use App\Models\PelaporanUTS;
use App\Models\PelaporanUAS;
use App\Models\PeriodePBL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PelaporanController extends Controller
{
    public function index()
    {
        $kode_tim = getKodeTimByAuth();

        if (!$kode_tim) {
            return redirect()->back()->with('error', 'Data tim periode aktif tidak ditemukan.');
        }

        $pelaporanUTS = PelaporanUTS::where('kode_tim', $kode_tim)->first();
        $pelaporanUAS = PelaporanUAS::where('kode_tim', $kode_tim)->first();

        return view('mahasiswa.pelaporan.pelaporan-pbl', compact('kode_tim', 'pelaporanUTS', 'pelaporanUAS'));
    }

 public function storeUTS(Request $request)
{
    $mahasiswa = Auth::guard('mahasiswa')->user();
    $kode_tim = getKodeTimByAuth();

    if (!$kode_tim) {
        return redirect()->back()->with('error', 'Data tim periode aktif tidak ditemukan.');
    }

    $validator = Validator::make($request->all(), [
        'keterangan' => 'required|string',
        'hasil' => 'nullable|file|mimes:pdf|max:10240',
        'link_youtube' => 'nullable|url',
        'laporan_pdf' => 'nullable|file|mimes:pdf|max:10240',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $pelaporan = PelaporanUTS::where('kode_tim', $kode_tim)->first();

    if ($pelaporan) {
        $pelaporan->keterangan = $request->keterangan;
        $pelaporan->link_youtube = $request->link_youtube;
        $pelaporan->updated_by = $mahasiswa->mahasiswa->nama;

        if ($request->hasFile('laporan_pdf')) {
            $laporanFile = $request->file('laporan_pdf');
            $laporanPath = $laporanFile->store('laporan_pbl', 'public');
            $pelaporan->laporan_pdf = $laporanPath;
        }

        if ($request->hasFile('hasil')) {
            $hasilFile = $request->file('hasil');
            $hasilPath = $hasilFile->store('laporan_pbl', 'public');
            $pelaporan->hasil = $hasilPath;
        }

        $pelaporan->save();
    } else {
        $laporanPath = null;
        $hasilPath = null;

        if ($request->hasFile('laporan_pdf')) {
            $laporanFile = $request->file('laporan_pdf');
            $laporanPath = $laporanFile->store('laporan_pbl', 'public');
        }

        if ($request->hasFile('hasil')) {
            $hasilFile = $request->file('hasil');
            $hasilPath = $hasilFile->store('laporan_pbl', 'public');
        }

        PelaporanUTS::create([
            'kode_tim' => $kode_tim,
            'keterangan' => $request->keterangan,
            'hasil' => $hasilPath,
            'link_youtube' => $request->link_youtube,
            'laporan_pdf' => $laporanPath,
            'updated_by' => $mahasiswa->mahasiswa->nama,
        ]);
    }

    Alert::success('Berhasil!', 'Laporan UTS berhasil disimpan!');
    return redirect()->route('mahasiswa.pelaporan-pbl');
}
public function storeUAS(Request $request)
{
    $mahasiswa = Auth::guard('mahasiswa')->user();
    $kode_tim = getKodeTimByAuth();

    if (!$kode_tim) {
        return redirect()->back()->with('error', 'Data tim periode aktif tidak ditemukan.');
    }

    $validator = Validator::make($request->all(), [
        'keterangan' => 'required|string',
        'hasil' => 'nullable|file|mimes:pdf|max:10240',
        'link_youtube' => 'nullable|url',
        'laporan_pdf' => 'nullable|file|mimes:pdf|max:10240',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $pelaporan = PelaporanUAS::where('kode_tim', $kode_tim)->first();

    if ($pelaporan) {
        $pelaporan->keterangan = $request->keterangan;
        $pelaporan->link_youtube = $request->link_youtube;
        $pelaporan->updated_by = $mahasiswa->mahasiswa->nama;

        if ($request->hasFile('laporan_pdf')) {
            $laporanFile = $request->file('laporan_pdf');
            $laporanPath = $laporanFile->store('laporan_pbl', 'public');
            $pelaporan->laporan_pdf = $laporanPath;
        }

        if ($request->hasFile('hasil')) {
            $hasilFile = $request->file('hasil');
            $hasilPath = $hasilFile->store('laporan_pbl', 'public');
            $pelaporan->hasil = $hasilPath;
        }

        $pelaporan->save();
    } else {
        $laporanPath = null;
        $hasilPath = null;

        if ($request->hasFile('laporan_pdf')) {
            $laporanFile = $request->file('laporan_pdf');
            $laporanPath = $laporanFile->store('laporan_pbl', 'public');
        }

        if ($request->hasFile('hasil')) {
            $hasilFile = $request->file('hasil');
            $hasilPath = $hasilFile->store('laporan_pbl', 'public');
        }

        PelaporanUAS::create([
            'kode_tim' => $kode_tim,
            'keterangan' => $request->keterangan,
            'hasil' => $hasilPath,
            'link_youtube' => $request->link_youtube,
            'laporan_pdf' => $laporanPath,
            'updated_by' => $mahasiswa->mahasiswa->nama,
        ]);
    }

    Alert::success('Berhasil!', 'Laporan UAS berhasil disimpan!');
    return redirect()->route('mahasiswa.pelaporan-pbl');
}
}