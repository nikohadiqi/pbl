<?php

namespace App\Http\Controllers\Website\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RencanaProyek;
use App\Models\TahapanPelaksanaan;
use App\Models\KebutuhanPeralatan;
use App\Models\tantangan;
use App\Models\Estimasi;
use App\Models\Biaya;
use App\Models\AnggotaTimPbl;
use App\Models\PeriodePBL;
use App\Models\TimPBL;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;

class RencanaProyekController extends Controller
{
    public function create()
    {
        $kodeTim = getKodeTimByAuth();

        $rencanaProyek = $kodeTim ? RencanaProyek::where('kode_tim', $kodeTim)->first() : null;
        $tahapanPelaksanaan = $kodeTim ? TahapanPelaksanaan::where('kode_tim', $kodeTim)->get() : collect();
        $kebutuhanPeralatan = $kodeTim ? KebutuhanPeralatan::where('kode_tim', $kodeTim)->get() : collect();
        $tantangan = $kodeTim ? tantangan::where('kode_tim', $kodeTim)->get() : collect();
        $biaya = $kodeTim ? Biaya::where('kode_tim', $kodeTim)->get() : collect();
        $estimasi = $kodeTim ? estimasi::where('kode_tim', $kodeTim)->get() : collect();

        $tim = $kodeTim ? TimPBL::with('manproFK')->where('kode_tim', $kodeTim)->first() : null;
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
            'manajerProyek'
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
            'ruang_lingkup' => 'nullable',
            'rancangan_sistem' => 'nullable',
            'evaluasi' => 'nullable',
        ]);

        $kodeTim = getKodeTimByAuth();
        if (!$kodeTim) return back()->with('error', 'Tim tidak ditemukan!');

        $rencanaProyek = RencanaProyek::firstOrNew(['kode_tim' => $kodeTim]);
        // Ambil data tim dan nama manajer proyek dari relasi
        $tim = TimPBL::with('manproFK')->where('kode_tim', $kodeTim)->first();
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
            'fase.*' => 'required|string',
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
            'fase.*' => 'required|string',
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
        $tahapan     = TahapanPelaksanaan::where('kode_tim', $kodeTim)->get()->toArray();
        $peralatan   = KebutuhanPeralatan::where('kode_tim', $kodeTim)->get()->toArray();
        $tantangan   = Tantangan::where('kode_tim', $kodeTim)->get()->toArray();
        $estimasi    = Estimasi::where('kode_tim', $kodeTim)->get()->toArray();
        $biaya       = Biaya::where('kode_tim', $kodeTim)->get()->toArray();

        $templatePath = resource_path('templates/rencana_proyek_template.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        // Set single value placeholders, gunakan null coalescing
        $templateProcessor->setValue('kode_tim', $kodeTim);
        $templateProcessor->setValue('judul_proyek', $rencanaProyek->judul_proyek ?? '-');
        $templateProcessor->setValue('manajer_proyek', $rencanaProyek->manajer_proyek ?? '-');
        $templateProcessor->setValue('pengusul_proyek', $rencanaProyek->pengusul_proyek ?? '-');
        $templateProcessor->setValue('waktu', $rencanaProyek->waktu ?? '-');
        $templateProcessor->setValue('sponsor', $rencanaProyek->sponsor ?? '-');
        $templateProcessor->setValue('biaya', $rencanaProyek->biaya ?? '-');
        $templateProcessor->setValue('klien', $rencanaProyek->klien ?? '-');
        $templateProcessor->setValue('luaran', $rencanaProyek->luaran ?? '-');
        // Fungsi bantu: render HTML ke TextRun untuk complexBlock
        function htmlToRichText($html): TextRun
        {
            $phpWord = new PhpWord();
            $section = $phpWord->addSection();
            Html::addHtml($section, $html, false, false);

            // Ambil elemen pertama dari section untuk dimasukkan ke complexBlock
            $elements = $section->getElements();
            foreach ($elements as $element) {
                if ($element instanceof TextRun) {
                    return $element;
                }
            }

            // Jika gagal, fallback ke teks biasa
            $textRun = new TextRun();
            $textRun->addText(strip_tags($html));
            return $textRun;
        }
        // Gunakan setComplexBlock untuk konten HTML
        $templateProcessor->setComplexBlock('ruang_lingkup', htmlToRichText($rencanaProyek->ruang_lingkup ?? '-'));
        $templateProcessor->setComplexBlock('evaluasi', htmlToRichText($rencanaProyek->evaluasi ?? '-'));
        $templateProcessor->setComplexBlock('rancangan_sistem', htmlToRichText($rencanaProyek->rancangan_sistem ?? '-'));

        // Fungsi bantu clone row dengan minimal 1 row
        $cloneRowSafely = function ($placeholder, $data, $callback) use ($templateProcessor) {
            $count = count($data);
            if ($count < 1) {
                $count = 1;
                $data = [['empty' => true]];
            }
            $templateProcessor->cloneRow($placeholder, $count);

            foreach ($data as $i => $item) {
                $index = $i + 1;
                $callback($templateProcessor, $index, $item);
            }
        };

        // TAHAPAN PELAKSANAAN
        $cloneRowSafely('minggu', $tahapan, function ($tpl, $i, $item) {
            $tpl->setValue("minggu#{$i}", $item['minggu'] ?? '-');
            $tpl->setValue("tahapan#{$i}", $item['tahapan'] ?? '-');
            $tpl->setValue("pic#{$i}", $item['pic'] ?? '-');
            $tpl->setValue("keterangan#{$i}", $item['keterangan'] ?? '-');
        });

        // KEBUTUHAN PERALATAN
        $cloneRowSafely('nomor_peralatan', $peralatan, function ($tpl, $i, $item) {
            $tpl->setValue("nomor_peralatan#{$i}", $item['nomor'] ?? '-');
            $tpl->setValue("fase_peralatan#{$i}", $item['fase'] ?? '-');
            $tpl->setValue("peralatan#{$i}", $item['peralatan'] ?? '-');
            $tpl->setValue("bahan#{$i}", $item['bahan'] ?? '-');
        });

        // TANTANGAN & ISU
        $cloneRowSafely('nomor_tantangan', $tantangan, function ($tpl, $i, $item) {
            $tpl->setValue("nomor_tantangan#{$i}", $item['nomor'] ?? '-');
            $tpl->setValue("proses#{$i}", $item['proses'] ?? '-');
            $tpl->setValue("isu#{$i}", $item['isu'] ?? '-');
            $tpl->setValue("level_resiko#{$i}", $item['level_resiko'] ?? '-');
            $tpl->setValue("catatan_tantangan#{$i}", $item['catatan'] ?? '-');
        });

        // ESTIMASI WAKTU
        $cloneRowSafely('fase_estimasi', $estimasi, function ($tpl, $i, $item) {
            $tpl->setValue("fase_estimasi#{$i}", $item['fase'] ?? '-');
            $tpl->setValue("uraian_pekerjaan#{$i}", $item['uraian_pekerjaan'] ?? '-');
            $tpl->setValue("estimasi_waktu#{$i}", $item['estimasi_waktu'] ?? '-');
            $tpl->setValue("catatan_estimasi#{$i}", $item['catatan'] ?? '-');
        });

        // BIAYA PROYEK
        $cloneRowSafely('fase_biaya', $biaya, function ($tpl, $i, $item) {
            $tpl->setValue("fase_biaya#{$i}", $item['fase'] ?? '-');
            $tpl->setValue("uraian_biaya#{$i}", $item['uraian_pekerjaan'] ?? '-');
            $tpl->setValue("perkiraan_biaya#{$i}", $item['perkiraan_biaya'] ?? '-');
            $tpl->setValue("catatan_biaya#{$i}", $item['catatan'] ?? '-');
        });

        $fileName = "Rencana_Pelaksanaan_Proyek_" . $kodeTim . ".docx";
        $tempFile = tempnam(sys_get_temp_dir(), 'word');
        $templateProcessor->saveAs($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
