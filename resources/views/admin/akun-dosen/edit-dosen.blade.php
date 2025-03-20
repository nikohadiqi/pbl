@extends('layouts.dashboardadmin-template')

@section('title','Edit Akun Dosen | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Edit Akun Dosen</h5>
        </div>
        <p class="text-muted">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

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

        <form class="mt-1" method="POST" action="{{ route('admin.dosen.update', $dosen->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nip" class="form-control-label">NIP/NIK/NIPPPK</label>
                <input class="form-control" name="nip" type="text" required value="{{ old('nip', $dosen->nip) }}">
            </div>
            <div class="form-group">
                <label for="nama" class="form-control-label">Nama Dosen</label>
                <input class="form-control" name="nama" type="text" required value="{{ old('nama', $dosen->nama) }}">
            </div>
            <div class="form-group">
                <label for="no_telp" class="form-control-label">Nomor Telephone</label>
                <input class="form-control" name="no_telp" type="text" value="{{ old('no_telp', $dosen->no_telp) }}">
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                <a href="{{ route('admin.dosen') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
