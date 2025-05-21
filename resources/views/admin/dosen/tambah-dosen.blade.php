@extends('layouts.dashboardadmin-template')

@section('title', 'Tambah Data Dosen | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Tambah Data Dosen')
@section('page-title-1', 'Data Dosen')
@section('page-title-1-url', route('admin.dosen'))
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Tambah Data Dosen</h5>
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

        {{-- Form Tambah Dosen --}}
        <form class="mt-1" method="POST" action="{{ route('admin.dosen.store') }}">
            @csrf
            <div class="form-group">
                <label for="nip" class="form-control-label">NIP/NIK/NIPPPK</label>
                <input class="form-control" name="nip" placeholder="Masukkan NIP/NIK/NIPPPK" type="number" required value="{{ old('nip') }}">
            </div>
            <div class="form-group">
                <label for="nama" class="form-control-label">Nama Dosen</label>
                <input class="form-control" name="nama" placeholder="Masukkan Nama Dosen" type="text" required value="{{ old('nama') }}">
            </div>
            <div class="form-group">
                <label for="no_telp" class="form-control-label">Nomor Telephone</label>
                <input class="form-control" name="no_telp" placeholder="Masukkan Nomor Telephone" type="number" value="{{ old('no_telp') }}">
            </div>
            <div class="form-group">
                <label for="email" class="form-control-label">Email</label>
                <input class="form-control" name="email" placeholder="Masukkan Email" type="email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="prodi">Program Studi</label>
                <select class="form-control" id="prodi" name="prodi">
                    <option value="" disabled selected hidden>Pilih Program Studi</option>
                    <option value="Teknologi Rekayasa Perangkat Lunak">Teknologi Rekayasa Perangkat Lunak</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jurusan">Jurusan</label>
                <input class="form-control" value="Bisnis dan Informatika" type="text" disabled>
                <input type="hidden" name="jurusan" value="Bisnis dan Informatika">
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
