@extends('layouts.dashboardadmin-template')

@section('title', ($isEdit ? 'Ubah' : 'Tambah') . 'Data Kelas | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', ($isEdit ? 'Ubah' : 'Tambah') . 'Data Kelas')
@section('page-title-1', 'Data Kelas')
@section('page-title-1-url', route('admin.kelas'))
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">{{ $isEdit ? 'Ubah' : 'Tambah' }} Data Kelas</h5>
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
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($isEdit)
            @method('PUT')
            @endif
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="tingkat">Tingkat <i class="bi bi-info-circle-fill text-info"> (Dalam Angka: 1, 2 , 3)</i></label>
                    <input type="number" name="tingkat" class="form-control"
                        value="{{ old('tingkat', $kelas->tingkat ?? '') }}" min="1" max="3" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="huruf">Kelas <i class="bi bi-info-circle-fill text-info"> (Alphabet: A, B , C, dst.)</i></label>
                    <input type="text" name="huruf" class="form-control"
                        value="{{ old('huruf', isset($kelas) ? substr($kelas->kelas, 1) : '') }}" maxlength="1" required
                        pattern="[A-Za-z]">
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-floppy me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.kelas') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
