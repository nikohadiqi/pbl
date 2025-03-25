@extends('layouts.dashboardadmin-template')

@section('title','Periode PBL | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Data Periode PBL</h4>
            <a href="{{ route('admin.tambah-periodepbl') }}">
                <button class="btn btn-primary text-white fw-bold"><i class="bi bi-plus me-2"></i>Tambah Data</button>
            </a>
        </div>
        <p class="text-muted">Periode Pengerjaan Proyek PBL Mahasiswa Prodi TRPL </p>
        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th>Nomor</th>
                        <th>Semester</th>
                        <th>Tahun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-weight-normal">
                    <tr>
                        <td>1</td>
                        <td>Semester 4</td>
                        <td>2024</td>
                        <td>
                            <a href="{{ route('admin.edit-periodepbl') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Semester 5</td>
                        <td>2024</td>
                        <td>
                            <a href="{{ route('admin.edit-periodepbl') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
