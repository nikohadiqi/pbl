@extends('layouts.dashboardadmin-template')

@section('title', 'Edit Tahapan Pelaksanaan Proyek | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">

    <!-- Notifikasi Sukses atau Error -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Edit Data Tahapan Pelaksanaan Proyek - Semester 5</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

        <form class="mt-1" action="{{ route('admin.tahapanpelaksanaan-sem5.update', $tahapan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Tahapan -->
            <div class="form-group mb-3">
                <label for="tahapan" class="form-control-label">Nama Tahapan Pelaksanaan Proyek</label>
                <input class="form-control @error('tahapan') is-invalid @enderror" type="text" name="tahapan" id="tahapan" value="{{ old('tahapan', $tahapan->tahapan) }}" required>
                @error('tahapan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- PIC -->
            <div class="form-group mb-3">
                <label for="pic" class="form-control-label">Person in Charge (PIC)</label>
                <select class="form-control @error('pic') is-invalid @enderror" name="pic" id="pic" required>
                    <option disabled selected>Pilih PIC</option>
                    <option value="Ketua Tim" {{ old('pic', $tahapan->pic) == 'Ketua Tim' ? 'selected' : '' }}>Ketua Tim</option>
                    <option value="Anggota Tim" {{ old('pic', $tahapan->pic) == 'Anggota Tim' ? 'selected' : '' }}>Anggota Tim</option>
                </select>
                @error('pic')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Score -->
            <div class="form-group mb-3">
                <label for="score" class="form-control-label">Score Progres Proyek (%)</label>
                <input class="form-control @error('score') is-invalid @enderror" type="number" name="score" id="score" value="{{ old('score', $tahapan->score) }}" min="5" max="10" required>
                @error('score')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                <a href="{{ route('admin.tahapanpelaksanaan-sem5') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
