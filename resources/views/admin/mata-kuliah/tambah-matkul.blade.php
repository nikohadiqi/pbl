@extends('layouts.dashboardadmin-template')

@section('title','Tambah Mata Kuliah | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Tambah Data Mata Kuliah</h5>
        </div>
        <p class="text-muted">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
        <form class="mt-1">
            <div class="form-group">
                <label for="mata_kuliah" class="form-control-label">Mata Kuliah</label>
                <input class="form-control" type="text" placeholder="Masukan Nama Mata Kuliah" id="mata_kuliah">
            </div>
            <div class="form-group">
                <label for="capaian" class="form-control-label">Capaian</label>
                <textarea class="form-control" id="capaian" rows="5" placeholder="Masukan Capaian Mata Kuliah"></textarea>
            </div>
            <div class="form-group">
                <label for="tujuan" class="form-control-label">Tujuan</label>
                <textarea class="form-control" id="tujuan" rows="5" placeholder="Masukan Tujuan Mata Kuliah"></textarea>
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                <button type="reset" class="btn btn-danger">Reset Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
