@extends('layouts.dashboardadmin-template')

@section('title','Mata Kuliah | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Mata Kuliah</h4>
            <a href="{{ route('admin.tambah-matkul') }}">
                <button class="btn btn-primary text-white fw-bold"><i class="bi bi-plus me-2"></i>Tambah Data</button>
            </a>
        </div>
        <p class="text-muted">Data Mata Kuliah Prodi TRPL</p>
        <div class="table-responsive mt-3">
            <table class="table table-hover" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th>Nomor</th>
                        <th>Mata Kuliah</th>
                        <th>Capaian</th>
                        <th>Tujuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Proyek Aplikasi Dasar</td>
                        <td>Capaian PAD</td>
                        <td>Tujuan PAD</td>
                        <td>
                            <a href="{{ route('admin.edit-matkul') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Basis Data</td>
                        <td>Capaian BD</td>
                        <td>Tujuan BD</td>
                        <td>
                            <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Analisis Desain Perangkat Lunak</td>
                        <td>Capaian ADPL</td>
                        <td>Tujuan ADPL</td>
                        <td>
                            <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Desain Pengalaman Pengguna</td>
                        <td>Capaian DPP</td>
                        <td>Tujuan DPP</td>
                        <td>
                            <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
