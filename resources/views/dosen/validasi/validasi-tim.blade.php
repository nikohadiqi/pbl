@extends('layouts.dashboarddosen-template')

@section('title','Validasi Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Validasi Tim PBL')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Validasi Tim PBL Yang Diampu</h4>
        </div>
        <p class="text-sm">Validasi Tim PBL yang diampu dalam periode saat ini (validasi saat tim pbl sesuai dengan kelas yang diampu)</p>

        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>ID Tim Proyek</th>
                        <th>Ketua Tim</th>
                        <th>Periode PBL</th>
                        <th>Manajer Proyek</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($timPBL as $index => $tim) --}}
                    <tr>
                        <td>1</td>
                        <td>2A1</td>
                        <td>Ketua</td>
                        <td>Semester 4</td>
                        <td>Ruth Ema</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="#" class="btn btn-sm btn-primary text-white">
                                    <i class="bi bi-check2-square"> Validasi Tim</i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
