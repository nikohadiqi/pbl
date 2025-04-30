@extends('layouts.dashboardmahasiswa-template')

@section('title','Dashboard Mahasiswa | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <!-- Project Card -->
    <div class="card p-4 mb-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5><strong>Judul Proyek</strong></h5>
            <p>Manajer Proyek: Nama</p>
            <p>Tim:</p>
            <ol>
                <li>Anggota 1</li>
                <li>Anggota 2</li>
                <li>Anggota 3</li>
                <li>Anggota 4</li>
                <li>Anggota 5</li>
            </ol>
            </div>

            <div class="progress-circle position-relative" style="width: 150px; height: 150px;">
                <svg viewBox="0 0 36 36" class="circular-chart">
                    <path class="circle-bg"
                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                        fill="none" stroke="#eee" stroke-width="3.8"></path>
                    <path class="circle" stroke-dasharray="80, 100"
                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                        fill="none" stroke="#ffcc00" stroke-width="3.8"></path>
                </svg>
                <div class="progress-text">80%</div>
            </div>

            <style>
                .progress-circle {
                    position: relative;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .progress-text {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    font-size: 18px;
                    font-weight: bold;
                    color: #333;
                }
            </style>
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
