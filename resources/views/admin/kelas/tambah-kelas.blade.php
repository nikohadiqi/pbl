@extends('layouts.dashboardadmin-template')

@section('title', 'Tambah Data Kelas | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Tambah Kelas')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Tambah Data Kelas</h5>
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

        {{-- Form Tambah Kelas --}}
        <form class="mt-1" method="POST" action="{{ route('admin.kelas.store') }}">
            @csrf
            <div class="form-group">
                <label for="kelas" class="form-control-label">Kelas</label>
                <input id="kelas" class="form-control" name="kelas" placeholder="Masukkan Nama Kelas" type="text" required value="{{ old('kelas') }}">
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
