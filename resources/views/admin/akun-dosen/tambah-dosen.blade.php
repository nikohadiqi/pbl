@extends('layouts.dashboardadmin-template')

@section('title','Tambah Akun Dosen | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Tambah Akun Dosen</h5>
        </div>
        <p class="text-muted">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
       <form class="mt-1">
            <div class="form-group">
                <label for="nip" class="form-control-label">NIP/NIK/NIPPPK</label>
                <input class="form-control" placeholder="Masukan NIP/NIK/NIPPPK" type="text">
            </div>
            <div class="form-group">
                <label for="nama" class="form-control-label">Nama Dosen</label>
                <input class="form-control" placeholder="Masukan Nama Dosen" type="text">
            </div>
            <div class="form-group">
                <label for="no_telp" class="form-control-label">Nomor Telephone</label>
                <input class="form-control" placeholder="Masukan Nomor Telephone" type="text">
            </div>
            <div class="form-grou mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                <button type="reset" class="btn btn-danger">Reset Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
