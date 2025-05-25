<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RencanaProyek;
use App\Models\TahapanPelaksanaan;
use App\Models\KebutuhanPeralatan;
use App\Models\Tantangan;
use App\Models\Estimasi;
use App\Models\Biaya;
use App\Models\Anggota_Tim_Pbl;
use App\Models\PeriodePBL;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Response;

class RencanaProyekController extends Controller
{
    public function create()
    {
        $kodeTim = getKodeTimByAuth();

        $rencanaProyek = $kodeTim ? RencanaProyek::where('kode_tim', $kodeTim)->first() : null;
        $tahapanPelaksanaan = $kodeTim ? TahapanPelaksanaan::where('kode_tim', $kodeTim)->get() : collect();
        $kebutuhanPeralatan = $kodeTim ? KebutuhanPeralatan::where('kode_tim', $kodeTim)->get() : collect();
        $tantangan = $kodeTim ? Tantangan::where('kode_tim', $kodeTim)->get() : collect();
        $biaya = $kodeTim ? Biaya::where('kode_tim', $kodeTim)->get() : collect();
        $estimasi = $kodeTim ? Estimasi::where('kode_tim', $kodeTim)->get() : collect();

        $tim = $kodeTim ? \App\Models\TimPbl::with('manproFK')->where('kode_tim', $kodeTim)->first() : null;
        $manajerProyek = $tim && $tim->manproFK ? [
            'nip' => $tim->manpro,
            'nama' => $tim->manproFK->nama,
        ] : null;

        return view('mahasiswa.rpp.rencana-proyek', compact(
            'rencanaProyek',
            'tahapanPelaksanaan',
            'kebutuhanPeralatan',
            'tantangan',
            'biaya',
            'estimasi',
            'manajerProyek' // kirim ke view
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_proyek' => 'nullable|string',
            'pengusul_proyek' => 'nullable|string',
            'manajer_proyek' => 'nullable|string',
            'luaran' => 'nullable|string',
            'sponsor' => 'nullable|string',
            'biaya' => 'nullable|string',
            'klien' => 'nullable|string',
            'waktu' => 'nullable|string',
            'ruang_lingkup' => 'nullable|string',
            'rancangan_sistem' => 'nullable|string',
            'evaluasi' => 'nullable|string',
        ]);

        $kodeTim = getKodeTimByAuth();
        if (!$kodeTim) return back()->with('error', 'Tim tidak ditemukan!');

        $rencanaProyek = RencanaProyek::firstOrNew(['kode_tim' => $kodeTim]);
        // Ambil data tim dan nama manajer proyek dari relasi
        $tim = \App\Models\TimPbl::with('manproFK')->where('kode_tim', $kodeTim)->first();
        $namaManpro = $tim && $tim->manproFK ? $tim->manproFK->nama : null;

        $rencanaProyek->fill($validated);
        $rencanaProyek->manajer_proyek = $namaManpro; // simpan nama manpro
        $rencanaProyek->kode_tim = $kodeTim;
        $rencanaProyek->save();

        Alert::success('Berhasil!', 'Deskripsi Proyek Berhasil Disimpan!');
        return redirect()->route('mahasiswa.rpp.rencana-proyek.create')->with('active_step', 'step1');
    }

    public function storeTahapanPelaksanaan(Request $request)
    {
        $validated = $request->validate([
            'minggu.*' => 'required|integer',
            'tahapan.*' => 'required|string',
            'pic.*' => 'required|string',
            'keterangan.*' => 'nullable|string',
        ]);

        $kodeTim = getKodeTimByAuth();
        if (!$kodeTim) return back()->with('error', 'Tim tidak ditemukan!');

        TahapanPelaksanaan::where('kode_tim', $kodeTim)->delete();

        foreach ($request->minggu as $i => $minggu) {
            TahapanPelaksanaan::create([
                'kode_tim' => $kodeTim,
                'minggu' => $minggu,
                'tahapan' => $request->tahapan[$i],
                'pic' => $request->pic[$i],
                'keterangan' => $request->keterangan[$i] ?? null,
            ]);
        }

        Alert::success('Berhasil!', 'Tahapan Pelaksanaan Berhasil Disimpan!');
        return redirect()->route('mahasiswa.rpp.rencana-proyek.create')->with('active_step', 'step2');
    }

    public function storeKebutuhanPeralatan(Request $request)
    {
        $validated = $request->validate([
            'nomor.*' => 'required|integer',
            'fase.*' => 'required|string',
            'peralatan.*' => 'nullable|string',
            'bahan.*' => 'nullable|string',
        ]);

        $kodeTim = getKodeTimByAuth();
        if (!$kodeTim) return back()->with('error', 'Tim tidak ditemukan!');

        KebutuhanPeralatan::where('kode_tim', $kodeTim)->delete();

        foreach ($request->nomor as $i => $nomor) {
            KebutuhanPeralatan::create([
                'kode_tim' => $kodeTim,
                'nomor' => $nomor,
                'fase' => $request->fase[$i],
                'peralatan' => $request->peralatan[$i] ?? null,
                'bahan' => $request->bahan[$i] ?? null,
            ]);
        }

        Alert::success('Berhasil!', 'Kebutuhan Peralatan Berhasil Disimpan!');
        return redirect()->route('mahasiswa.rpp.rencana-proyek.create')->with('active_step', 'step3');
    }

    public function storeTantangan(Request $request)
    {
        $validated = $request->validate([
            'nomor.*' => 'required|integer',
            'proses.*' => 'required|string',
            'isu.*' => 'nullable|string',
            'level_resiko.*' => 'nullable|string',
            'catatan.*' => 'nullable|string',
        ]);

        $kodeTim = getKodeTimByAuth();
        if (!$kodeTim) return back()->with('error', 'Tim tidak ditemukan!');

        Tantangan::where('kode_tim', $kodeTim)->delete();

        foreach ($request->nomor as $i => $nomor) {
            Tantangan::create([
                'kode_tim' => $kodeTim,
                'nomor' => $nomor,
                'proses' => $request->proses[$i],
                'isu' => $request->isu[$i] ?? null,
                'level_resiko' => $request->level_resiko[$i] ?? null,
                'catatan' => $request->catatan[$i] ?? null,
            ]);
        }

        Alert::success('Berhasil!', 'Tantangan dan Isu Berhasil Disimpan!');
        return redirect()->route('mahasiswa.rpp.rencana-proyek.create')->with('active_step', 'step4');
    }

    public function storeBiaya(Request $request)
    {
        $validated = $request->validate([
            'fase.*' => 'required|integer',
            'uraian_pekerjaan.*' => 'nullable|string',
            'perkiraan_biaya.*' => 'nullable|string',
            'catatan.*' => 'nullable|string',
        ]);

        $kodeTim = getKodeTimByAuth();
        if (!$kodeTim) return back()->with('error', 'Tim tidak ditemukan!');

        Biaya::where('kode_tim', $kodeTim)->delete();

        foreach ($request->fase as $i => $fase) {
            Biaya::create([
                'kode_tim' => $kodeTim,
                'fase' => $fase,
                'uraian_pekerjaan' => $request->uraian_pekerjaan[$i],
                'perkiraan_biaya' => $request->perkiraan_biaya[$i],
                'catatan' => $request->catatan[$i] ?? null,
            ]);
        }

        Alert::success('Berhasil!', 'Biaya Proyek Berhasil Disimpan!');
        return redirect()->route('mahasiswa.rpp.rencana-proyek.create')->with('active_step', 'step5');
    }

    public function storeEstimasi(Request $request)
    {
        $validated = $request->validate([
            'fase.*' => 'required|integer',
            'uraian_pekerjaan.*' => 'nullable|string',
            'estimasi_waktu.*' => 'nullable|string',
            'catatan.*' => 'nullable|string',
        ]);

        $kodeTim = getKodeTimByAuth();
        if (!$kodeTim) return back()->with('error', 'Tim tidak ditemukan!');

        Estimasi::where('kode_tim', $kodeTim)->delete();

        foreach ($request->fase as $i => $fase) {
            Estimasi::create([
                'kode_tim' => $kodeTim,
                'fase' => $fase,
                'uraian_pekerjaan' => $request->uraian_pekerjaan[$i],
                'estimasi_waktu' => $request->estimasi_waktu[$i],
                'catatan' => $request->catatan[$i] ?? null,
            ]);
        }

        Alert::success('Berhasil!', 'Estimasi Waktu Pekerjaan Berhasil Disimpan!');
        return redirect()->route('mahasiswa.rpp.rencana-proyek.create')->with('active_step', 'step6');
    }
    public function exportWord()
{
    $kodeTim = getKodeTimByAuth();
    if (!$kodeTim) return back()->with('error', 'Tim tidak ditemukan!');

    $rencanaProyek = RencanaProyek::where('kode_tim', $kodeTim)->first();
    $tahapan = TahapanPelaksanaan::where('kode_tim', $kodeTim)->get();
    $peralatan = KebutuhanPeralatan::where('kode_tim', $kodeTim)->get();
    $tantangan = Tantangan::where('kode_tim', $kodeTim)->get();
    $estimasi = Estimasi::where('kode_tim', $kodeTim)->get();
    $biaya = Biaya::where('kode_tim', $kodeTim)->get();

    // Path ke template word dengan placeholders
    $templatePath = storage_path('app/templates/rencana_proyek_template.docx');
    $templateProcessor = new TemplateProcessor($templatePath);

    // Set single value placeholders
    $templateProcessor->setValue('kode_tim', $kodeTim ?? '-'); 
    $templateProcessor->setValue('judul_proyek', $rencanaProyek->judul_proyek ?? '-');
    $templateProcessor->setValue('manajer_proyek', $rencanaProyek->manajer_proyek ?? '-');
    $templateProcessor->setValue('pengusul_proyek', $rencanaProyek->pengusul_proyek ?? '-');
    $templateProcessor->setValue('waktu', $rencanaProyek->waktu ?? '-');
    $templateProcessor->setValue('ruang_lingkup', $rencanaProyek->ruang_lingkup ?? '-');
    $templateProcessor->setValue('evaluasi', $rencanaProyek->evaluasi ?? '-');
    $templateProcessor->setValue('sponsor', $rencanaProyek->sponsor ?? '-');
    $templateProcessor->setValue('biaya', $rencanaProyek->biaya ?? '-');
    $templateProcessor->setValue('klien', $rencanaProyek->klien ?? '-');
    $templateProcessor->setValue('rancangan_sistem', $rencanaProyek->rancangan_sistem ?? '-');
    $templateProcessor->setValue('luaran' , $rencanaProyek->luaran ?? '-');

    // Buat string tabel untuk Tahapan Pelaksanaan
    $tahapanString = "";
    foreach ($tahapan as $item) {
        $tahapanString .= "Minggu {$item->minggu} : {$item->tahapan}, PIC: {$item->pic}";
        if ($item->keterangan) {
            $tahapanString .= ", Keterangan: {$item->keterangan}";
        }
        $tahapanString .= "\n";
    }
    $templateProcessor->setValue('tahapan_pelaksanaan', $tahapanString ?: '-');

    // Buat string tabel untuk Kebutuhan Peralatan
    $peralatanString = "";
    foreach ($peralatan as $item) {
        $peralatanString .= "Nomor {$item->nomor}, Fase: {$item->fase}, Peralatan: {$item->peralatan}, Bahan: {$item->bahan}\n";
    }
    $templateProcessor->setValue('kebutuhan_peralatan', $peralatanString ?: '-');

    // Buat string tabel untuk Tantangan dan Isu
    $tantanganString = "";
    foreach ($tantangan as $item) {
        $tantanganString .= "Nomor {$item->nomor}, Proses: {$item->proses}, Isu: {$item->isu}, Level Resiko: {$item->level_resiko}, Catatan: {$item->catatan}\n";
    }
    $templateProcessor->setValue('tantangan', $tantanganString ?: '-');

    // Buat string tabel untuk Estimasi Waktu Pekerjaan
    $estimasiString = "";
    foreach ($estimasi as $item) {
        $estimasiString .= "Fase {$item->fase}, Uraian: {$item->uraian_pekerjaan}, Estimasi Waktu: {$item->estimasi_waktu}, Catatan: {$item->catatan}\n";
    }
    $templateProcessor->setValue('estimasi_waktu', $estimasiString ?: '-');

    // Buat string tabel untuk Biaya Proyek
    $biayaString = "";
    foreach ($biaya as $item) {
        $biayaString .= "Fase {$item->fase}, Uraian Pekerjaan: {$item->uraian_pekerjaan}, Perkiraan Biaya: {$item->perkiraan_biaya}, Catatan: {$item->catatan}\n";
    }
    $templateProcessor->setValue('biaya_proyek', $biayaString ?: '-');

    // Generate file
    $fileName = "Rencana_Proyek_" . $kodeTim . ".docx";

    // Simpan sementara file
    $tempFile = tempnam(sys_get_temp_dir(), 'word');
    $templateProcessor->saveAs($tempFile);

    // Kirim file sebagai download response
    return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
}

}
