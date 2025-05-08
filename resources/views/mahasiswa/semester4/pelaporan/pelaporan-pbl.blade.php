@extends('layouts.dashboardmahasiswa-template')

@section('title','Laporan PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Laporan PBL')
@section('content')
<div class="container mt-4">
    <div class="row g-4">
        <!-- Card Laporan UTS -->
        <div class="col-12">
            <a href="{{ route('mahasiswa.pelaporan-pbl.laporan-uts') }}" class="text-decoration-none">
                <div class="card shadow-lg h-100 card-hover">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-2">Laporan UTS</h4>
                        </div>
                        <div class="bg-secondary-subtle p-3 rounded">
                            <i class="bi bi-file-earmark-text fs-1"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card Laporan UAS -->
        <div class="col-12">
            <a href="{{ route('mahasiswa.pelaporan-pbl.laporan-uas') }}" class="text-decoration-none">
                <div class="card shadow-lg h-100 card-hover">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-2">Laporan UAS</h4>
                        </div>
                        <div class="bg-secondary-subtle p-3 rounded">
                            <i class="bi bi-file-earmark-text fs-1"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .card-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15);
    }
</style>
@endpush
