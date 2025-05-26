@extends('layouts.dashboardadmin-template')

@section('title', 'Tambah Mata Kuliah')
@section('page-title', 'Tambah Data Mata Kuliah')
@section('page-title-1', 'Data Mata Kuliah')
@section('page-title-1-url', route('admin.matkul'))
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <h5 class="fw-bold">Tambah Data Mata Kuliah</h5>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

        {{-- Form Tambah --}}
        <form action="{{ route('admin.matkul.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="kode">Kode Mata Kuliah</label>
                <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                       value="{{ old('kode') }}" required>
                @error('kode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="matakuliah">Nama Mata Kuliah</label>
                <input type="text" name="matakuliah" class="form-control @error('matakuliah') is-invalid @enderror"
                       value="{{ old('matakuliah') }}" required>
                @error('matakuliah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="sks">SKS</label>
                <input type="number" name="sks" min="1" max="10" class="form-control @error('sks') is-invalid @enderror"
                       value="{{ old('sks') }}" required>
                @error('sks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="program_studi">Program Studi</label>
                <select class="form-control" id="program_studi" name="program_studi">
                    <option value="" disabled selected hidden>Pilih Program Studi</option>
                    <option value="Teknologi Rekayasa Perangkat Lunak">Teknologi Rekayasa Perangkat Lunak</option>
                </select>
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2"><i class="bi bi-floppy me-1"></i> Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
