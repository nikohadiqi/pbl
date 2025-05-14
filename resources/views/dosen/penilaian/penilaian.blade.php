@extends('layouts.dashboarddosen-template')

@section('title','Penilaian Mahasiswa | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Penilaian Mahasiswa')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4 shadow-sm rounded-3" style="background-color: #fff;">
        {{-- FORM FILTER --}}
        <div class="mb-2">
            <form method="POST" action="#">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <select name="kelas" class="form-control">
                            <option value="">-- Pilih Kelas --</option>
                            <option value="4A">4A</option>
                            <option value="4B">4B</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <select name="tahun" class="form-control">
                            <option value="">-- Pilih Periode PBL --</option>
                            <option value="1">Semester 4 / Tahun 2025</option>
                            <option value="2">Semester 5 / Tahun 2025</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                    </div>
                </div>
            </form>
            <hr class="horizontal dark mt-2">
        </div>

        {{-- Tabel Mahasiswa --}}
        {{-- <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Penilaian Mahasiswa</h4>
        </div>
        <p class="text-sm">Penilaian mahasiswa sesuai kelas yang diampu</p> --}}
        <div class="table-responsive">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Kelas</th>
                        <th>Tim PBL</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($timPBL as $index => $tim) --}}
                    <tr>
                        <td>1</td>
                        <td>362355401085</td>
                        <td>Rio Adjie Wiguna</td>
                        <td>2C</td>
                        <td>2C 1</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('dosen.penilaian.beri-nilai') }}" class="btn btn-sm btn-primary text-white">
                                    <i class="bi bi-highlighter"> Beri Nilai</i>
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
