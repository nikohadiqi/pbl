@extends('layouts.dashboardadmin-template')

@section('title','Edit Periode PBL | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Edit Data Periode PBL</h5>
        </div>
        <p class="text-muted">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
       <form class="mt-1">
            <div class="form-group">
                <label for="semester" class="form-control-label">Semester Pelaksanaan PBL</label>
                <select class="form-control" id="semester">
                    <option disabled>Pilih Semester</option>
                    <option selected>Semester 4</option>
                    <option>Semester 5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tahun_pelaksanaan" class="form-control-label">Tahun Pelaksanaan PBL</label>
                <input class="form-control" value="2024" type="text">
            </div>
            <div class="form-grou mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                <button type="reset" class="btn btn-danger">Reset Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
