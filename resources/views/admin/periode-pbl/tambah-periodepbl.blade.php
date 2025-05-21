@extends('layouts.dashboardadmin-template')

@section('title','Tambah Periode PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Tambah Data Periode PBL')
@section('page-title-1', 'Data Dosen Pengampu')
@section('page-title-1-url', route('admin.pengampu'))
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Tambah Data Periode PBL</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

        {{-- Flash Message --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- Form Tambah Periode PBL --}}
        <form class="mt-1" method="POST" action="{{ route('admin.periodepbl.store') }}">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="semester" class="form-control-label">Semester Pelaksanaan PBL</label>
                    <input type="number" name="semester" class="form-control @error('semester') is-invalid @enderror"
                        min="1" max="6" placeholder="Masukkan Semester (Angka)" value="{{ old('semester') }}" required>
                    @error('semester')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="tahun" class="form-control-label">Tahun Pelaksanaan PBL</label>
                    <input class="form-control @error('tahun') is-invalid @enderror"
                        placeholder="Masukkan Tahun (contoh: 2024)" type="text" name="tahun" id="tahun" maxlength="4"
                        pattern="\d{4}" value="{{ old('tahun') }}" required>
                    @error('tahun')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="tanggal_mulai" class="form-control-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                        value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="tanggal_selesai" class="form-control-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                        value="{{ old('tanggal_selesai') }}" required>
                    @error('tanggal_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
