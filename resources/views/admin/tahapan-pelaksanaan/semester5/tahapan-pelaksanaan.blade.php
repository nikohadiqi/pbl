@extends('layouts.dashboardadmin-template')

@section('title','Tahapan Pelaksanaan Proyek | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Tahapan Pelaksanaan Proyek - Semester 5</h4>
            <a href="{{ route('admin.tambah-tahapanpelaksanaan-sem5') }}">
                <button class="btn btn-primary text-white fw-bold"><i class="bi bi-plus me-2"></i>Tambah Data</button>
            </a>
        </div>
        <p class="text-sm">Tahapan Pelaksanaan Proyek Mingguan Mahasiswa</p>
        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th>Minggu Ke-</th>
                        <th>Nama Tahapan</th>
                        <th>Person in Charge</th>
                        <th>Bobot Progres</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-weight-normal">
                    <tr>
                        <td>1</td>
                        <td class="text-wrap">Mengidentifikasi fitur tambahan yang akan dikembangkan dalam waktu pelaksanaan proyek</td>
                        <td>[perwakilan tim]</td>
                        <td>5%</td>
                        <td>
                            <a href="{{ route('admin.edit-tahapanpelaksanaan-sem5') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="text-wrap">Melakukan verifikasi fitur tambahan dan penyusunan Rencana Pelaksanaan Proyek bersama Manajer Proyek</td>
                        <td>[manajer proyek]</td>
                        <td>5%</td>
                        <td>
                            <a href="{{ route('admin.edit-tahapanpelaksanaan-sem5') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="text-wrap">Melakukan update spesifikasi dan desain perangkat lunak menyesuaikan kebutuhan terbaru</td>
                        <td>[perwakilan tim]</td>
                        <td>5%</td>
                        <td>
                            <a href="{{ route('admin.edit-tahapanpelaksanaan-sem5') }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="text-wrap">Pengembangan Fitur Tambahan 1</td>
                        <td>[perwakilan tim]</td>
                        <td>5%</td>
                        <td>
                            <a href="{{ route('admin.edit-tahapanpelaksanaan-sem5') }}">
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
