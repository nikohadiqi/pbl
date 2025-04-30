@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rencana Proyek</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $isEdit = isset($rencanaProyek) && $rencanaProyek != null;
    @endphp

    <form method="POST" action="{{ $isEdit ? route('rencana-proyek.update', $rencanaProyek->id_proyek) : route('rencana-proyek.store') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="id_proyek" class="form-label">ID Proyek</label>
            <input type="text" class="form-control" id="id_proyek" name="id_proyek" value="{{ old('id_proyek', $rencanaProyek->id_proyek ?? '') }}">
            @error('id_proyek')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="judul_proyek" class="form-label">Judul Proyek</label>
            <input type="text" class="form-control" id="judul_proyek" name="judul_proyek" value="{{ old('judul_proyek', $rencanaProyek->judul_proyek ?? '') }}">
            @error('judul_proyek')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="pengusul_proyek" class="form-label">Pengusul Proyek</label>
            <input type="text" class="form-control" id="pengusul_proyek" name="pengusul_proyek" value="{{ old('pengusul_proyek', $rencanaProyek->pengusul_proyek ?? '') }}">
            @error('pengusul_proyek')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="manajer_proyek" class="form-label">Manajer Proyek</label>
            <input type="text" class="form-control" id="manajer_proyek" name="manajer_proyek" value="{{ old('manajer_proyek', $rencanaProyek->manajer_proyek ?? '') }}">
            @error('manajer_proyek')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="luaran" class="form-label">Luaran</label>
            <textarea class="form-control" id="luaran" name="luaran">{{ old('luaran', $rencanaProyek->luaran ?? '') }}</textarea>
            @error('luaran')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="sponsor" class="form-label">Sponsor</label>
            <textarea class="form-control" id="sponsor" name="sponsor">{{ old('sponsor', $rencanaProyek->sponsor ?? '') }}</textarea>
            @error('sponsor')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="biaya" class="form-label">Biaya</label>
            <input type="number" step="0.01" class="form-control" id="biaya" name="biaya" value="{{ old('biaya', $rencanaProyek->biaya ?? '') }}">
            @error('biaya')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="klien" class="form-label">Klien</label>
            <input type="text" class="form-control" id="klien" name="klien" value="{{ old('klien', $rencanaProyek->klien ?? '') }}">
            @error('klien')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="waktu" class="form-label">Waktu</label>
            <input type="text" class="form-control" id="waktu" name="waktu" value="{{ old('waktu', $rencanaProyek->waktu ?? '') }}">
            @error('waktu')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="ruang_lingkup" class="form-label">Ruang Lingkup</label>
            <textarea class="form-control" id="ruang_lingkup" name="ruang_lingkup">{{ old('ruang_lingkup', $rencanaProyek->ruang_lingkup ?? '') }}</textarea>
            @error('ruang_lingkup')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="rancangan_sistem" class="form-label">Rancangan Sistem</label>
            <textarea class="form-control" id="rancangan_sistem" name="rancangan_sistem">{{ old('rancangan_sistem', $rencanaProyek->rancangan_sistem ?? '') }}</textarea>
            @error('rancangan_sistem')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="minggu" class="form-label">Minggu</label>
            <input type="number" class="form-control" id="minggu" name="minggu" value="{{ old('minggu', $rencanaProyek->minggu ?? '') }}">
            @error('minggu')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="tahapan" class="form-label">Tahapan</label>
            <input type="text" class="form-control" id="tahapan" name="tahapan" value="{{ old('tahapan', $rencanaProyek->tahapan ?? '') }}">
            @error('tahapan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="pic" class="form-label">PIC</label>
            <input type="text" class="form-control" id="pic" name="pic" value="{{ old('pic', $rencanaProyek->pic ?? '') }}">
            @error('pic')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan">{{ old('keterangan', $rencanaProyek->keterangan ?? '') }}</textarea>
            @error('keterangan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="proses" class="form-label">Proses</label>
            <input type="text" class="form-control" id="proses" name="proses" value="{{ old('proses', $rencanaProyek->proses ?? '') }}">
            @error('proses')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="peralatan" class="form-label">Peralatan</label>
            <input type="text" class="form-control" id="peralatan" name="peralatan" value="{{ old('peralatan', $rencanaProyek->peralatan ?? '') }}">
            @error('peralatan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="bahan" class="form-label">Bahan</label>
            <input type="text" class="form-control" id="bahan" name="bahan" value="{{ old('bahan', $rencanaProyek->bahan ?? '') }}">
            @error('bahan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="tantangan" class="form-label">Tantangan</label>
            <input type="text" class="form-control" id="tantangan" name="tantangan" value="{{ old('tantangan', $rencanaProyek->tantangan ?? '') }}">
            @error('tantangan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <input type="text" class="form-control" id="level" name="level" value="{{ old('level', $rencanaProyek->level ?? '') }}">
            @error('level')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="rencana_tindakan" class="form-label">Rencana Tindakan</label>
            <textarea class="form-control" id="rencana_tindakan" name="rencana_tindakan">{{ old('rencana_tindakan', $rencanaProyek->rencana_tindakan ?? '') }}</textarea>
            @error('rencana_tindakan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control" id="catatan" name="catatan">{{ old('catatan', $rencanaProyek->catatan ?? '') }}</textarea>
            @error('catatan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="uraian_pekerjaan" class="form-label">Uraian Pekerjaan</label>
            <textarea class="form-control" id="uraian_pekerjaan" name="uraian_pekerjaan">{{ old('uraian_pekerjaan', $rencanaProyek->uraian_pekerjaan ?? '') }}</textarea>
            @error('uraian_pekerjaan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="perkiraan_biaya" class="form-label">Perkiraan Biaya</label>
            <input type="number" step="0.01" class="form-control" id="perkiraan_biaya" name="perkiraan_biaya" value="{{ old('perkiraan_biaya', $rencanaProyek->perkiraan_biaya ?? '') }}">
            @error('perkiraan_biaya')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="estimasi" class="form-label">Estimasi</label>
            <input type="text" class="form-control" id="estimasi" name="estimasi" value="{{ old('estimasi', $rencanaProyek->estimasi ?? '') }}">
            @error('estimasi')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $rencanaProyek->nama ?? '') }}">
            @error('nama')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $rencanaProyek->nim ?? '') }}">
            @error('nim')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="program_studi" class="form-label">Program Studi</label>
            <input type="text" class="form-control" id="program_studi" name="program_studi" value="{{ old('program_studi', $rencanaProyek->program_studi ?? '') }}">
            @error('program_studi')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
    </form>
</div>
@endsection
