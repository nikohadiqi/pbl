@extends('layouts.dashboardmahasiswa-template')

@section('title', 'Form Laporan UAS | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Form Laporan UAS')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <h5 class="fw-bold">Form Laporan UAS</h5>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($kode_tim))
            <div class="alert alert-info">
                <strong>Kode Tim Anda:</strong> {{ $kode_tim }}
            </div>
        @endif

        {{-- Form untuk laporan UAS --}}
        <form class="mt-1" method="POST" action="{{ route('mahasiswa.pelaporan-pbl.laporan-uas.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="keterangan" class="form-control-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="5" placeholder="Jelaskan kegiatan UAS...">{{ old('keterangan', $laporan->keterangan ?? '') }}</textarea>
            </div>
            <div class="form-group">
                <label for="link_drive" class="form-control-label">Link Drive (Dokumentasi)</label>
                <input class="form-control" name="link_drive" placeholder="Masukan Link Drive" type="text" value="{{ old('link_drive', $laporan->link_drive ?? '') }}">
            </div>
            <div class="form-group">
                <label for="link_youtube" class="form-control-label">Link YouTube</label>
                <input class="form-control" name="link_youtube" placeholder="Masukan Link Youtube" type="text" value="{{ old('link_youtube', $laporan->link_youtube ?? '') }}">
            </div>
            <div class="form-group">
                <label for="laporan_pdf" class="form-control-label">Unggah Laporan (PDF)</label>
                <input class="form-control" name="laporan_pdf" type="file" accept="application/pdf">
                @if(isset($laporan) && $laporan->laporan_pdf)
                    <p><a href="{{ asset('storage/' . $laporan->laporan_pdf) }}" target="_blank">Lihat Laporan PDF</a></p>
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
