@extends('layouts.dashboarddosen-template')

@section('title','Penilaian Mahasiswa | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Daftar Tim PBL / Penilaian Mahasiswa')
@section('content')
<div class="container py-4">
    <div class="card p-4 shadow-sm rounded-3" style="background-color: #fff;">
        @for ($i = 1; $i <= 5; $i++)
        <div class="card shadow-sm my-3 border">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">Mahasiswa {{ $i }}</h6>
                    <p class="fw-bold mb-1">Nama</p>
                    <p class="mb-3">NIM</p>
                    <a href="#" class="btn btn-dark btn-sm">Beri Nilai</a>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection

@push('css')
<style>
    .card {
        border-radius: 10px;
    }

    .card-body {
        padding: 1.5rem;
    }
</style>
@endpush
