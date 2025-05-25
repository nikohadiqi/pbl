@extends('layouts.dashboarddosen-template')

@section('title','Dasbor Dosen | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Dasbor')
@section('content')
<div class="container-fluid py-4">
    {{-- Rekap Total Dashboard --}}
    <div class="row">
        <div class="col-xl-6 col-sm-12 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Tim Yang Diampu</p>
                                <h3 class="font-weight-bolder">
                                    {{ $timCount }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni ni-laptop text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-12 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Mahasiswa yang diampu</p>
                                <h3 class="font-weight-bolder">
                                    {{ $mahasiswaCount }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End of Rekap Total Dashboard --}}
    {{-- Chart --}}
    {{-- Progres PBL --}}
    <div class="row mt-4">
        <div class="col-md-12 mt-3">
            <div class="card z-index-2 border border-light shadow-sm rounded-3 overflow-hidden">
                <div class="card-header p-3 pb-0">
                    <h6>Rekap Progres Pelaksanaan PBL Tim Mahasiswa</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="line-chart-gradient" class="chart-canvas" height="600"
                            style="display: block; box-sizing: border-box; height: 300px; width: 502.2px;"
                            width="1004"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Pelaporan dan Nilai --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card z-index-2 border border-light shadow-sm rounded-3 overflow-hidden">
                <div class="card-header p-3 pb-0">
                    <h6>Rekap Unggah Pelaporan PBL (Laporan UTS / Laporan UAS)</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="bar-chart" class="chart-canvas" height="600"
                            style="display: block; box-sizing: border-box; height: 300px; width: 502.2px;"
                            width="1004"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-md-0 mt-4">
            <div class="card z-index-2 border border-light shadow-sm rounded-3 overflow-hidden">
                <div class="card-header p-3 pb-0">
                    <h6>Rekap Mahasiswa yang sudah dinilai</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="pie-chart" class="chart-canvas" height="600"
                            style="display: block; box-sizing: border-box; height: 300px; width: 502.2px;"
                            width="1004"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End of Chart --}}
</div>
@endsection

@push('script')
@php
    $chartLabels = $labels ?? ["10", "20", "30", "40", "50", "60", "70", "80", "90", "100"];
    $chartData = $data ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    $chartTotalTim = $totalTim ?? 10;
@endphp
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Line Chart with Gradient (unified logic)
        var ctxGradient = document.getElementById("line-chart-gradient").getContext("2d");
        var gradientStroke = ctxGradient.createLinearGradient(0, 0, 0, 400);
        gradientStroke.addColorStop(0, 'rgba(247, 205, 7, 0.4)');
        gradientStroke.addColorStop(1, 'rgba(247, 205, 7, 0)');

        var labels = @json($chartLabels);
        var data = @json($chartData);
        var totalTim = {{ $chartTotalTim }};

        // Optional: Tambahkan % jika belum ada
        labels = labels.map(label => label.toString().includes('%') ? label : label + '%');

        new Chart(ctxGradient, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "Jumlah Tim per Progress",
                    data: data,
                    borderColor: "rgba(247, 205, 7, 1)",
                    backgroundColor: gradientStroke,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: totalTim,
                        ticks: {
                            precision: 0,
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Bar Chart: Rekap Tim Unggah Pelaporan PBL
        const barCtx = document.getElementById("bar-chart").getContext("2d");
        new Chart(barCtx, {
            type: "bar",
            data: {
                labels: ["Sudah Unggah UTS", "UTS Belum Diunggah", "Sudah Unggah UAS", "UAS Belum Diunggah"],
                datasets: [{
                    label: "Jumlah Tim",
                    data: [
                        {{ $jumlahSudahUts }},
                        {{ $jumlahBelumUts }},
                        {{ $jumlahSudahUas }},
                        {{ $jumlahBelumUas }}
                    ],
                    backgroundColor: [
                        "rgba(45, 206, 137, 0.7)", // success
                        "rgba(245, 54, 92, 0.7)",   // danger
                        "rgba(45, 206, 137, 0.7)", // success
                        "rgba(245, 54, 92, 0.7)"   // danger
                    ],
                    borderColor: [
                        "rgba(45, 206, 137, 1)", // success
                        "rgba(245, 54, 92, 1)",   // danger
                        "rgba(45, 206, 137, 1)", // success
                        "rgba(245, 54, 92, 1)"   // danger
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top', // 'top' = atas kanan secara default (Chart.js)
                        align: 'end' // 'end' = ke kanan (start = kiri)
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Pie Chart: Rekap Mahasiswa yang Sudah Dinilai
        const pieCtx = document.getElementById("pie-chart").getContext("2d");
        new Chart(pieCtx, {
            type: "pie",
            data: {
                labels: ["Sudah Dinilai", "Belum Dinilai"],
                datasets: [{
                    data: [{{ $mahasiswaSudahDinilai }}, {{ $mahasiswaBelumDinilai }}],
                    backgroundColor: [
                        "rgba(45, 206, 137, 0.7)", // success
                        "rgba(245, 54, 92, 0.7)"   // danger
                    ],
                    borderColor: [
                        "rgba(45, 206, 137, 1)", // success
                        "rgba(245, 54, 92, 1)"   // danger
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom', // 'top' = atas kanan secara default (Chart.js)
                        align: 'end' // 'end' = ke kanan (start = kiri)
                    }
                },
            }
        });
    });
</script>
@endpush
