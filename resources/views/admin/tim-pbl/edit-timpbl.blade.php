@extends('layouts.dashboardadmin-template')

@section('title','Edit Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Edit Data Tim PBL</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
       <form class="mt-1">
            <div class="row">
                <label for="id_pbl" class="form-control-label">ID Proyek PBL</label>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control" id="kelas">
                            <option disabled>Pilih Kelas</option>
                            <option selected>3A</option>
                            <option>3B</option>
                            <option>3C</option>
                            <option>3D</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input class="form-control" type="text" value="1" id="kode_tim">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="ketua_tim" class="form-control-label">Ketua Tim PBL</label>
                <div class="input-group">
                    <input class="form-control" value="362355401001" type="search">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label for="periode_pbl" class="form-control-label">Periode PBL</label>
                <select class="form-control" id="periode_pbl">
                    <option disabled>Pilih Periode PBL</option>
                    <option selected>2025</option>
                    <option>2024</option>
                    <option>2023</option>
                </select>
            </div>
            <div class="form-grou mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                <button type="reset" class="btn btn-danger">Reset Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
