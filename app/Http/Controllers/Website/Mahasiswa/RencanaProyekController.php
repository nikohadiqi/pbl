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

// ✅ TAHAPAN PELAKSANAAN
    $jumlahTahapan = count($tahapan);
    $templateProcessor->cloneRow('minggu', $jumlahTahapan);
    foreach ($tahapan as $index => $item) {
        $i = $index + 1;
        $templateProcessor->setValue("minggu#{$i}", $item['minggu'] ?? '-');
        $templateProcessor->setValue("tahapan#{$i}", $item['tahapan'] ?? '-');
        $templateProcessor->setValue("pic#{$i}", $item['pic'] ?? '-');
        $templateProcessor->setValue("keterangan#{$i}", $item['keterangan'] ?? '-');
    }

    // ✅ KEBUTUHAN PERALATAN
    $jumlahPeralatan = count($peralatan);
    $templateProcessor->cloneRow('nomor_peralatan', $jumlahPeralatan);
    foreach ($peralatan as $index => $item) {
        $i = $index + 1;
        $templateProcessor->setValue("nomor_peralatan#{$i}", $item['nomor'] ?? '-');
        $templateProcessor->setValue("fase_peralatan#{$i}", $item['fase'] ?? '-');
        $templateProcessor->setValue("peralatan#{$i}", $item['peralatan'] ?? '-');
        $templateProcessor->setValue("bahan#{$i}", $item['bahan'] ?? '-');
    }

    // ✅ TANTANGAN & ISU
    $jumlahTantangan = count($tantangan);
    $templateProcessor->cloneRow('nomor_tantangan', $jumlahTantangan);
    foreach ($tantangan as $index => $item) {
        $i = $index + 1;
        $templateProcessor->setValue("nomor_tantangan#{$i}", $item['nomor'] ?? '-');
        $templateProcessor->setValue("proses#{$i}", $item['proses'] ?? '-');
        $templateProcessor->setValue("isu#{$i}", $item['isu'] ?? '-');
        $templateProcessor->setValue("level_resiko#{$i}", $item['level_resiko'] ?? '-');
        $templateProcessor->setValue("catatan_tantangan#{$i}", $item['catatan'] ?? '-');
    }

    // ✅ ESTIMASI WAKTU
    $jumlahEstimasi = count($estimasi);
    $templateProcessor->cloneRow('fase_estimasi', $jumlahEstimasi);
    foreach ($estimasi as $index => $item) {
        $i = $index + 1;
        $templateProcessor->setValue("fase_estimasi#{$i}", $item['fase'] ?? '-');
        $templateProcessor->setValue("uraian_pekerjaan#{$i}", $item['uraian_pekerjaan'] ?? '-');
        $templateProcessor->setValue("estimasi_waktu#{$i}", $item['estimasi_waktu'] ?? '-');
        $templateProcessor->setValue("catatan_estimasi#{$i}", $item['catatan'] ?? '-');
    }

    // ✅ BIAYA PROYEK
    $jumlahBiaya = count($biaya);
    $templateProcessor->cloneRow('fase_biaya', $jumlahBiaya);
    foreach ($biaya as $index => $item) {
        $i = $index + 1;
        $templateProcessor->setValue("fase_biaya#{$i}", $item['fase'] ?? '-');
        $templateProcessor->setValue("uraian_biaya#{$i}", $item['uraian_pekerjaan'] ?? '-');
        $templateProcessor->setValue("perkiraan_biaya#{$i}", $item['perkiraan_biaya'] ?? '-');
        $templateProcessor->setValue("catatan_biaya#{$i}", $item['catatan'] ?? '-');
    }

    // ✅ Simpan dan kirim file Word
    $fileName = "Rencana_Proyek_" . $kodeTim . ".docx";
    $tempFile = tempnam(sys_get_temp_dir(), 'word');
    $templateProcessor->saveAs($tempFile);

    // Kirim file sebagai download response
    return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
}

}
