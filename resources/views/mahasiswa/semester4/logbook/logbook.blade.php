@extends('layouts.dashboardmahasiswa-template')

@section('title','Logbook Mingguan | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Logbook Mingguan')
@section('content')
<div class="container py-4">
    @for ($i = 1; $i <= 16; $i++)
        <div class="card shadow-sm my-3 border">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">Logbook Minggu Ke-{{ $i }}</h6>
                    <p class="fw-bold mb-1">Tahapan Pelaksanaan Mingguan</p>
                    <p class="mb-2">Keterangan</p>
                    <a href="{{ route('mahasiswa.logbook.create') }}" class="btn btn-dark btn-sm">Isi Logbook</a>
                </div>
                <div class="text-center">
                    <div class="position-relative" style="width: 70px; height: 70px;">
                        <svg width="70" height="70">
                            <circle cx="35" cy="35" r="30" stroke="#ccc" stroke-width="5" fill="none" />
                            <circle cx="35" cy="35" r="30" stroke="#000" stroke-width="5" fill="none"
                                stroke-dasharray="188"
                                stroke-dashoffset="{{ 188 - (188 * 4 / 4) }}"
                                transform="rotate(-90 35 35)" />
                        </svg>
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-sm">
                            <strong>4%</strong><br>
                            <small class="text-muted">Progress</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endfor
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
