@extends('layouts.dashboardmahasiswa-template')

@section('title','Dashboard Mahasiswa | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Dasbor')
@section('content')
<div class="container-fluid py-4">
    <!-- Project Card -->
    <div class="card p-4 mb-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-1"><strong>Nomor ID:</strong> {{ $tim->kode_tim }}</p>
                <h5><strong>{{ $tim->rencanaProyek->judul_proyek ?? 'Belum Ada Judul PBL' }}</strong></h5>
                <p>Manajer Proyek: {{ $tim->manproFK->nama ?? '-' }}</p>
                <p>Anggota Tim:</p>
                <ol>
                    @foreach($tim->anggota as $anggota)
                    <li>{{ $anggota->mahasiswaFK->nama }}</li>
                    @endforeach
                </ol>
            </div>

            <div class="text-center mt-3 mt-md-0" style="width: 150px;">
                <div class="position-relative">
                    <svg width="120" height="120">
                        <circle cx="60" cy="60" r="50" stroke="#eee" stroke-width="10" fill="none" />
                        <circle cx="60" cy="60" r="50" stroke="#F7CD07" stroke-width="10" fill="none"
                            stroke-dasharray="{{ 2 * 3.14 * 50 }}"
                            stroke-dashoffset="{{ 2 * 3.14 * 50 * (1 - $tim->progress_percent / 100) }}"
                            stroke-linecap="round" transform="rotate(-90 60 60)" />
                    </svg>
                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                        <strong style="font-size: 1.5rem;">{{ $tim->progress_percent
                            }}%</strong><br><small>Progres</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Project Card -->

    <!-- Logbook & Report Cards -->
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <small>Pengisian Logbook</small>
                <h5><strong>Logbook</strong></h5>
                <p>Minggu ke 5</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <small>Pengisian Laporan</small>
                <h5><strong>Laporan UTS</strong></h5>
                <p>Minggu ke 8</p>
            </div>
        </div>
    </div>
</div>
@endsection
