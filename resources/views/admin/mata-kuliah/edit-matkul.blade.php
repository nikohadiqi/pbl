@extends('layouts.dashboardadmin-template')

@section('title','Ubah Mata Kuliah | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Ubah Data Mata Kuliah')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <h5 class="fw-bold">Ubah Data Mata Kuliah</h5>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
        <form action="{{ route('admin.matkul.update', $matkul->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Kode Mata Kuliah -->
            <div class="form-group mb-3">
                <label for="kode">Kode Mata Kuliah</label>
                <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                    value="{{ old('kode', $matkul->kode) }}" required>
                @error('kode')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- Nama Mata Kuliah -->
            <div class="form-group mb-3">
                <label for="matakuliah">Nama Mata Kuliah</label>
                <input type="text" name="matakuliah" class="form-control @error('matakuliah') is-invalid @enderror"
                    value="{{ old('matakuliah', $matkul->matakuliah) }}" required>
                @error('matakuliah')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- Prodi -->
            <div class="form-group">
                <label for="program_studi">Program Studi</label>
                <select class="form-control" id="program_studi" name="program_studi" required>
                    <option value="" disabled hidden>Pilih Program Studi</option>
                    <option value="Teknologi Rekayasa Perangkat Lunak"
                        {{ old('program_studi', $matkul->program_studi ?? '') == 'Teknologi Rekayasa Perangkat Lunak' ? 'selected' : '' }}>
                        Teknologi Rekayasa Perangkat Lunak
                    </option>
                </select>
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
