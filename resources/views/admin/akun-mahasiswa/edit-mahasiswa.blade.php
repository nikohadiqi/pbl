@extends('layouts.dashboardadmin-template')

@section('title','Edit Akun Mahasiswa | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Edit Akun Mahasiswa</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
    
        <form class="mt-3" action="{{ route('admin.update-mahasiswa', $mahasiswa->nim) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group mb-3">
                <label for="nim" class="form-control-label">NIM</label>
                <input class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" type="text" required>
                @error('nim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="nama" class="form-control-label">Nama Mahasiswa</label>
                <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" type="text" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="kelas" class="form-control-label">Kelas</label>
                <input class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas', $mahasiswa->kelas) }}" type="text" required>
                @error('kelas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                <button type="reset" class="btn btn-danger">Reset Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
