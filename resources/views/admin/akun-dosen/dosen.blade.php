@extends('layouts.dashboardadmin-template')

@section('title','Akun Dosen | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Akun Dosen</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.tambah-dosen') }}">
                    <button class="btn btn-primary text-white fw-bold"><i class="bi bi-plus me-2"></i>Tambah Data</button>
                </a>
                <a href="#">
                    <button class="btn btn-primary text-white fw-bold"><i class="bi bi-upload me-2"></i>Impor Data</button>
                </a>
            </div>
        </div>
        <p class="text-muted">Akun Dosen yang digunakan dalam sistem</p>
        <div class="table-responsive mt-3">
            <table class="table table-hover" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Dosen</th>
                        <th>NIP/NIK/NIPPPK</th>
                        <th>No Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Mohamad Dimyati Ayatullah, S.T., M.Kom.</td>
                        <td>197601222021211000</td>
                        <td>081234567890</td>
                        <td>
                            <a href="{{ route('admin.edit-dosen') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Dianni Yusuf, S.Kom., M.Kom.</td>
                        <td>198403052021212004</td>
                        <td>081234567890</td>
                        <td>
                            <a href="{{ route('admin.edit-dosen') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>I Wayan Suardinata, S.Kom., M.T.</td>
                        <td>198010222015041000</td>
                        <td>081234567890</td>
                        <td>
                            <a href="{{ route('admin.edit-dosen') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Ruth Ema Febrita, S.Pd., M.Kom.</td>
                        <td>199202272020122000</td>
                        <td>081234567890</td>
                        <td>
                            <a href="{{ route('admin.edit-dosen') }}">
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
