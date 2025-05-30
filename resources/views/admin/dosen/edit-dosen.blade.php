@extends('layouts.dashboardadmin-template')

@section('title','Ubah Data Dosen | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Ubah Data Dosen')
@section('page-title-1', 'Data Dosen')
@section('page-title-1-url', route('admin.dosen'))
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Ubah Data Dosen</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

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

        <form class="mt-1" method="POST" action="{{ route('admin.dosen.update', $dosen->nip) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nip" class="form-control-label">NIP/NIK/NIPPPK</label>
                <input class="form-control" name="nip" type="number" value="{{ $dosen->nip }}">
            </div>

            <div class="form-group">
                <label for="nama" class="form-control-label">Nama Dosen</label>
                <input class="form-control" name="nama" placeholder="Masukkan Nama Dosen" type="text" required value="{{ old('nama', $dosen->nama) }}">
            </div>

            <div class="form-group">
                <label for="no_telp" class="form-control-label">Nomor Telephone</label>
                <input class="form-control" name="no_telp" placeholder="Masukkan Nomor Telephone" type="number" value="{{ old('no_telp', $dosen->no_telp) }}">
            </div>

            <div class="form-group">
                <label for="email" class="form-control-label">Email</label>
                <input class="form-control" name="email" placeholder="Masukkan Email" type="email" value="{{ old('email', $dosen->email) }}">
            </div>

            <div class="form-group">
                <label for="prodi">Program Studi</label>
                <input class="form-control" value="{{ old('prodi', $dosen->prodi) }}" type="text" disabled>
                <input type="hidden" name="prodi" value="Teknologi Rekayasa Perangkat Lunak">
            </div>

            <div class="form-group">
                <label for="jurusan">Jurusan</label>
                <input class="form-control" value="{{ old('jurusan', $dosen->jurusan) }}" type="text" disabled>
                <input type="hidden" name="jurusan" value="Bisnis dan Informatika">
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2"><i class="bi bi-floppy me-1"></i> Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
