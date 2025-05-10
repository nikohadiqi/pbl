@extends('layouts.dashboardmahasiswa-template')

@section('title','Logbook Mingguan | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Logbook Mingguan')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">

        <h5 class="fw-bold">Form Logbook Mingguan</h5>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('mahasiswa.logbook.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label class="form-label fw-semibold">Aktivitas</label>
                <input 
                    type="text" 
                    name="aktivitas" 
                    class="form-control" 
                    value="{{ old('aktivitas', $logbook->aktivitas ?? '') }}" 
                    required
                >
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-semibold">Hasil (Link Drive / Keterangan)</label>
                <input 
                    type="text" 
                    name="hasil" 
                    class="form-control" 
                    value="{{ old('hasil', $logbook->hasil ?? '') }}" 
                    required
                >
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-semibold">Foto Kegiatan (opsional)</label>
                <input 
                    type="file" 
                    name="foto_kegiatan" 
                    class="form-control"
                >
                @if (!empty($logbook?->foto_kegiatan))
                    <div class="mt-2">
                        <p class="mb-1">Foto Sebelumnya:</p>
                        <img src="{{ asset('storage/' . $logbook->foto_kegiatan) }}" alt="Foto Kegiatan" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                @endif
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-semibold">Anggota (opsional)</label>
                @for($i = 1; $i <= 5; $i++)
                    <input 
                        type="text" 
                        name="anggota{{ $i }}" 
                        class="form-control mb-2" 
                        placeholder="Anggota {{ $i }}" 
                        value="{{ old("anggota$i", $logbook?->{"anggota$i"} ?? '') }}"
                    >
                @endfor
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-semibold">Progress (%)</label>
                <input 
                    type="number" 
                    name="progress" 
                    class="form-control" 
                    min="0" 
                    max="100" 
                    value="{{ old('progress', $logbook->progress ?? '') }}" 
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">Simpan Logbook</button>
        </form>
    </div>
</div>
@endsection
