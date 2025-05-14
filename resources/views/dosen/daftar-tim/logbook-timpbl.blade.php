@extends('layouts.dashboarddosen-template')

@section('title','Logbook | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Daftar Tim PBL / Logbook')
@section('content')
<div class="container py-4">
    <div class="card p-4 shadow-sm rounded-3" style="background-color: #fff;">
        @for ($i = 1; $i <= 16; $i++)
        <div class="card shadow-sm my-3 border">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">Logbook Minggu Ke-{{ $i }}</h6>
                    <p class="fw-bold mb-1">Tahapan Pelaksanaan Mingguan</p>
                    <p class="mb-2">Keterangan</p>
                    <a href="#" class="btn btn-dark btn-sm">Lihat Logbook</a>
                </div>
                <div class="text-center mt-3 mt-md-0" style="width: 150px;">
                    <div class="position-relative">
                        <svg width="120" height="120">
                            <circle cx="60" cy="60" r="50" stroke="#eee" stroke-width="10" fill="none" />
                            <circle cx="60" cy="60" r="50" stroke="#000" stroke-width="10" fill="none"
                                stroke-dasharray="{{ 2 * 3.14 * 50 }}"
                                stroke-dashoffset="{{ 2 * 3.14 * 50 * (1 - 0.82) }}" stroke-linecap="round"
                                transform="rotate(-90 60 60)" />
                        </svg>
                        <div class="position-absolute top-50 start-50 translate-middle text-center">
                            <strong style="font-size: 1.5rem;">4%</strong><br><small>Progres</small>
                        </div>
                    </div>
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
