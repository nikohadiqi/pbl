@extends('layouts.dashboardadmin-template')

@section('title', 'Tambah Tahapan Pelaksanaan Semester 4')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <h5 class="fw-bold">Tambah Tahapan Pelaksanaan - Semester 4</h5>
        <p class="text-sm">Tambahkan tahapan pelaksanaan proyek berdasarkan semester 4</p>
        
        <form action="{{ route('admin.tahapanpelaksanaan.store') }}" method="POST">
            @csrf
            
            <!-- Nama Tahapan -->
            <div class="form-group mb-3">
                <label for="tahapan">Nama Tahapan</label>
                <input type="text" name="tahapan" class="form-control @error('tahapan') is-invalid @enderror" placeholder="Masukkan Nama Tahapan" value="{{ old('tahapan') }}" required>
                @error('tahapan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- PIC (Dropdown) -->
            <div class="form-group mb-3">
                <label for="pic">PIC (Penanggung Jawab)</label>
                <select name="pic" class="form-control @error('pic') is-invalid @enderror" required>
                    <option value="" disabled selected>Pilih PIC</option>
                    <option value="Ketua Tim" {{ old('pic') == 'Ketua Tim' ? 'selected' : '' }}>Ketua Tim</option>
                    <option value="Anggota Tim" {{ old('pic') == 'Anggota Tim' ? 'selected' : '' }}>Anggota Tim</option>
                </select>
                @error('pic')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Bobot Progres -->
            <div class="form-group mb-3">
                <label for="score">Bobot Progres (%)</label>
                <input type="number" name="score" class="form-control @error('score') is-invalid @enderror" min="5" max="10" placeholder="Masukkan Score (5-10)" value="{{ old('score') }}" required>
                @error('score')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="{{ route('admin.tahapanpelaksanaan-sem4') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
