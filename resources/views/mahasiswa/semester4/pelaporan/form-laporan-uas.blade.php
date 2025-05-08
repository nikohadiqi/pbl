@extends('layouts.dashboardmahasiswa-template')

@section('title', 'Form Laporan UAS | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Form Laporan UAS')
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

        {{-- Form Tambah Dosen --}}
        <form class="mt-1" method="POST" action="">
            @csrf
            <div class="form-group">
                <label for="keterangan" class="form-control-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="5" placeholder="Jelaskan mengenai kegiatan PBL yang dikerjakan.."></textarea>
            </div>
            <div class="form-group">
                <label for="link_drive" class="form-control-label">Link Drive Laporan (Foto Kegiatan, Hasil Desain, Hasil Pengujian, dll)</label>
                <input class="form-control" name="link_drive" placeholder="Masukan Link Drive" type="text">
            </div>
            <div class="form-group">
                <label for="link_yt" class="form-control-label">Link Youtube Proyek PBL</label>
                <input class="form-control" name="link_yt" placeholder="Masukan Link Youtube" type="text">
            </div>
            <div class="form-group">
                <label for="laporan" class="form-control-label">Unggah Laporan</label>
                <input class="form-control" name="laporan" placeholder="Masukkan File Hasil PBL" type="file">
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
