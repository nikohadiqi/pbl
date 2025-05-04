@extends('layouts.dashboardadmin-template')

@section('title', 'Tambah Data Mahasiswa | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Tambah Data Mahasiswa')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Tambah Data Mahasiswa</h5>
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

        {{-- Form Tambah Mahasiswa --}}
        <form class="mt-1" method="POST" action="{{ route('admin.mahasiswa.store') }}">
            @csrf
            <div class="form-group">
                <label for="nim" class="form-control-label">NIM</label>
                <input id="nim" class="form-control" name="nim" placeholder="Masukkan NIM" type="number" required value="{{ old('nim') }}">
            </div>

            <div class="form-group">
                <label for="nama" class="form-control-label">Nama Mahasiswa</label>
                <input id="nama" class="form-control" name="nama" placeholder="Masukkan Nama Mahasiswa" type="text" required value="{{ old('nama') }}">
            </div>

            {{-- Ambil Data Kelas --}}
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <select class="form-control" id="kelas" name="kelas">
                    <option value="" disabled selected hidden>Pilih Kelas</option>
                    @foreach($kelas as $kelas)
                    <option value="{{ $kelas->kelas }}">{{ $kelas->kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="program_studi">Program Studi</label>
                <select class="form-control" id="program_studi" name="program_studi">
                    <option value="" disabled selected hidden>Pilih Program Studi</option>
                    <option value="Teknologi Rekayasa Perangkat Lunak">Teknologi Rekayasa Perangkat Lunak</option>
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
