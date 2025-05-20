@extends('layouts.dashboardmahasiswa-template')

@section('title', 'Form Laporan UTS | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Form Laporan UTS')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Form Laporan UAS</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

        {{-- Menampilkan pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <form class="mt-1" method="POST" action="{{ route('mahasiswa.pelaporan-pbl.laporan-uas.store') }}" enctype="multipart/form-data">
    @csrf
  <input type="hidden" name="kode_tim" value="{{ $kode_tim }}">
            <div class="form-group">
                <label for="keterangan" class="form-control-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="5" placeholder="Jelaskan mengenai kegiatan PBL yang dikerjakan..">{{ old('keterangan', $pelaporan->keterangan ?? '') }}</textarea>
            </div>
            <div class="form-group">
                <label for="link_drive" class="form-control-label">Link Drive Laporan</label>
                <input class="form-control" name="link_drive" placeholder="Masukan Link Drive" type="text" value="{{ old('link_drive', $pelaporan->link_drive ?? '') }}">
            </div>
            <div class="form-group">
                <label for="link_youtube" class="form-control-label">Link Youtube Proyek PBL</label>
                <input class="form-control" name="link_youtube" placeholder="Masukan Link Youtube" type="text" value="{{ old('link_youtube', $pelaporan->link_youtube ?? '') }}">
            </div>
            <div class="form-group">
                <label for="laporan_pdf" class="form-control-label">Unggah Laporan (PDF)</label>
                <input class="form-control" name="laporan_pdf" placeholder="Masukkan File Laporan UTS" type="file">
                @if($pelaporan && $pelaporan->laporan_pdf)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $pelaporan->laporan_pdf) }}" target="_blank">Lihat Laporan UTS</a>
                    </div>
                @endif
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
