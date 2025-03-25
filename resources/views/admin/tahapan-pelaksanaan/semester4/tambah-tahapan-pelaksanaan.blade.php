@extends('layouts.dashboardadmin-template')

@section('title','Tambah Tahapan Pelaksanaan Proyek | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Tambah Data Tahapan Pelaksanaan Proyek - Semester 4</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
       <form class="mt-1">
            <div class="form-group">
                <label for="minggu" class="form-control-label">Minggu Ke-</label>
                <select class="form-control" id="minggu">
                    <option selected disabled>Pilih Minggu Pelaksanaan</option>
                    <option>Minggu Ke-1</option>
                    <option>Minggu Ke-2</option>
                    <option>Minggu Ke-3</option>
                    <option>Minggu Ke-4</option>
                    <option>Minggu Ke-5</option>
                    <option>Minggu Ke-6</option>
                    <option>Minggu Ke-7</option>
                    <option>Minggu Ke-8</option>
                    <option>Minggu Ke-9</option>
                    <option>Minggu Ke-10</option>
                    <option>Minggu Ke-11</option>
                    <option>Minggu Ke-12</option>
                    <option>Minggu Ke-13</option>
                    <option>Minggu Ke-14</option>
                    <option>Minggu Ke-15</option>
                    <option>Minggu Ke-16</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_tahapan" class="form-control-label">Nama Tahapan Pelaksanaan Proyek</label>
                <input class="form-control" placeholder="Masukan Nama Tahapan Pelaksanaan Proyek" type="text">
            </div>
            <div class="form-group">
                <label for="pic" class="form-control-label">Person in Charge (PIC)</label>
                <select class="form-control" id="pic">
                    <option selected disabled>Pilih PIC</option>
                    <option>[perwakilan tim]</option>
                    <option>[manajer proyek]</option>
                </select>
            </div>
            <div class="form-group">
                <label for="bobot-progress" class="form-control-label">Bobot Progres Proyek</label>
                <input class="form-control" type="number" id="bobot-progress" max="10" min="5">
            </div>
            <div class="form-grou mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                <button type="reset" class="btn btn-danger">Reset Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
