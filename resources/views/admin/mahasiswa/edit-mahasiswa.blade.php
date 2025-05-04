@extends('layouts.dashboardadmin-template')

@section('title','Ubah Data Mahasiswa | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Ubah Data Mahasiswa')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Ubah Data Mahasiswa</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

        <form class="mt-3" action="{{ route('admin.mahasiswa.update', $mahasiswa->nim) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="nim" class="form-control-label">NIM</label>
                <input class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" type="number">
                @error('nim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="nama" class="form-control-label">Nama Mahasiswa</label>
                <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" type="text">
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Data kelas dalam DB -->
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <select class="form-control" id="kelas" name="kelas">
                    <option value="" disabled selected hidden>Pilih Kelas</option>
                    @foreach($kelas as $kelas)
                    <option value="{{ $kelas->kelas }}"
                        {{ old('kelas', $mahasiswa->kelas) == $kelas->kelas ? 'selected' : '' }}>
                        {{ $kelas->kelas }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="program_studi">Program Studi</label>
                <select class="form-control" id="program_studi" name="program_studi" required>
                    <option value="" disabled hidden>Pilih Program Studi</option>
                    <option value="Teknologi Rekayasa Perangkat Lunak"
                        {{ old('program_studi', $mahasiswa->program_studi ?? '') == 'Teknologi Rekayasa Perangkat Lunak' ? 'selected' : '' }}>
                        Teknologi Rekayasa Perangkat Lunak
                    </option>
                </select>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
