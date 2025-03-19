@extends('layouts.dashboardadmin-template')

@section('title','Akun Mahasiswa | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Akun Mahasiswa</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.tambah-mahasiswa') }}">
                    <button class="btn btn-primary text-white fw-bold"><i class="bi bi-plus me-2"></i>Tambah Data</button>
                </a>
                <a href="#">
                    <button class="btn btn-primary text-white fw-bold"><i class="bi bi-upload me-2"></i>Impor Data</button>
                </a>
            </div>
        </div>
        <p class="text-muted">Akun Mahasiswa yang digunakan dalam sistem ke proyek PBL masing-masing</p>
        <div class="table-responsive mt-3">
            <table class="table table-hover" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Achmad Nico Wildhan</td>
                        <td>362355401017</td>
                        <td>3A</td>
                        <td>
                            <a href="{{ route('admin.edit-mahasiswa') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Rio Adjie Wiguna</td>
                        <td>362355401085</td>
                        <td>3A</td>
                        <td>
                            <a href="{{ route('admin.edit-mahasiswa') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Wahyu Eka</td>
                        <td>362355401025</td>
                        <td>3A</td>
                        <td>
                            <a href="{{ route('admin.edit-mahasiswa') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Ken Affila</td>
                        <td>362355401030</td>
                        <td>3A</td>
                        <td>
                            <a href="{{ route('admin.edit-mahasiswa') }}">
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
