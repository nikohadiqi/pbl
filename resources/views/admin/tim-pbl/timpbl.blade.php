@extends('layouts.dashboardadmin-template')

@section('title','Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Data Tim PBL Mahasiswa</h4>
            <a href="{{ route('admin.tambah-timpbl') }}">
                <button class="btn btn-primary text-white fw-bold"><i class="bi bi-plus me-2"></i>Tambah Data</button>
            </a>
        </div>
        <p class="text-sm mb-0">Tim proyek PBL mahasiswa dengan id proyek, judul dan ketua tim PBL Program Studi TRPL</p>
        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th>ID Proyek</th>
                        <th>Judul PBL</th>
                        <th>Ketua Tim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-weight-normal">
                    <tr>
                        <td>3A_1</td>
                        <td>Sistem Monitoring Laboratorium</td>
                        <td>
                            <p>362355401001</p>
                            <p>Rio Adjie</p>
                        </td>
                        <td>
                            <a href="{{ route('admin.edit-timpbl') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3A_2</td>
                        <td>Aplikasi Cek Kadar Gula Darah</td>
                        <td>
                            <p>362355401017</p>
                            <p>Achmad Nico</p>
                        </td>
                        <td>
                            <a href="{{ route('admin.edit-timpbl') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3A_3</td>
                        <td>Aplikasi berbasis Web dalam Pengelolaan Arsip</td>
                        <td>
                            <p>362355401025</p>
                            <p>Wahyu Eka</p>
                        </td>
                        <td>
                            <a href="{{ route('admin.edit-timpbl') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3A_4</td>
                        <td>Web Pengenalan Perusahan Abdi Jaya</td>
                        <td>
                            <p>362355401030</p>
                            <p>Ken Affila</p>
                        </td>
                        <td>
                            <a href="{{ route('admin.edit-timpbl') }}">
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
