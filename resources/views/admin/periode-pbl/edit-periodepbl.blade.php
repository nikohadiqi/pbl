@extends('layouts.dashboardadmin-template')

@section('title','Ubah Periode PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Ubah Data Periode PBL')
@section('page-title-1', 'Data Dosen Pengampu')
@section('page-title-1-url', route('admin.pengampu'))
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Ubah Data Periode PBL</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

        <!-- Flash Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form Ubah Periode PBL -->
        <form class="mt-1" method="POST" action="{{ route('admin.periodepbl.update', $periode->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="semester" class="form-control-label">Semester Pelaksanaan PBL</label>
                    <input class="form-control @error('semester') is-invalid @enderror" type="number" name="semester"
                        id="semester" value="{{ old('semester', $periode->semester) }}" min="1" max="6">
                    @error('semester')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="tahun_pelaksanaan" class="form-control-label">Tahun Pelaksanaan PBL</label>
                    <input class="form-control" placeholder="Masukan Tahun Periode Pelaksanaan PBL" type="text"
                        name="tahun" value="{{ $periode->tahun }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="tanggal_mulai" class="form-control-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control"
                        value="{{ $periode->tanggal_mulai ? \Carbon\Carbon::parse($periode->tanggal_mulai)->format('Y-m-d') : '' }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="tanggal_selesai" class="form-control-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control"
                        value="{{ $periode->tanggal_selesai ? \Carbon\Carbon::parse($periode->tanggal_selesai)->format('Y-m-d') : '' }}">
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
