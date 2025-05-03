@extends('layouts.dashboardadmin-template')

@section('title','Edit Data Kelas | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Ubah Kelas')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Edit Data Kelas</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

        <form class="mt-3" action="{{ route('admin.update-kelas', $kelas->kelas) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="kelas" class="form-control-label">Kelas</label>
                <input class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas', $kelas->kelas) }}" type="text" required>
                @error('kelas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
