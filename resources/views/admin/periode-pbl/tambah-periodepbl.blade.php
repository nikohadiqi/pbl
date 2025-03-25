@extends('layouts.dashboardadmin-template')

@section('title','Tambah Periode PBL | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Tambah Data Periode PBL</h5>
        </div>
        <p class="text-muted">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

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
            <div class="form-group">
                <label for="semester" class="form-control-label">Semester Pelaksanaan PBL</label>
                <select class="form-control" id="semester" name="semester" required>
                    <option selected disabled>Pilih Semester</option>
                    <option value="4" {{ old('semester') == '4' ? 'selected' : '' }}>Semester 4</option>
                    <option value="5" {{ old('semester') == '5' ? 'selected' : '' }}>Semester 5</option>
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="tahun" class="form-control-label">Tahun Pelaksanaan PBL</label>
                <input class="form-control" 
                       placeholder="Masukkan Tahun (contoh: 2024)" 
                       type="text" 
                       name="tahun" 
                       id="tahun"
                       maxlength="4" 
                       pattern="\d{4}" 
                       value="{{ old('tahun') }}" 
                       required>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                <button type="reset" class="btn btn-danger">Reset Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
