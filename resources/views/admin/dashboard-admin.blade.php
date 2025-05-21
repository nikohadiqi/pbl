@extends('layouts.dashboardadmin-template')

@section('title','Dashboard Admin | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Dasbor')
@section('content')
<div class="container-fluid py-4">
    {{-- Rekap Total Dashboard --}}
    <div class="row">
        <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Tim Proyek PBL</p>
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
        <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Mahasiswa</p>
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
        <div class="col-xl-4 col-sm-12 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Dosen</p>
                                <h3 class="font-weight-bolder">
                                    {{ $dosenCount }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-hat-3 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End of Rekap Total Dashboard --}}
    {{-- Tabel Dashboard --}}
    {{-- Riwayat Tim PBL --}}
    <div class="card mt-4">
        <div class="card-header pb-0 p-3">
            <div class="d-flex justify-content-between">
                <h6 class="mb-2">Data Terbaru Tim PBL</h6>
            </div>
        </div>
        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-normal">
                <thead class="table-light">
                    <tr>
                        <th>Kode Tim</th>
                        <th>Judul Proyek PBL</th>
                        <th>Anggota Tim PBL</th>
                        <th>Manajer Proyek</th>
                        <th>Kelas</th>
                        <th>Progres Proyek</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timpbl as $item)
                    <tr>
                        <td>{{ $item->kode_tim ?? '-' }}</td>
                        <td class="text-wrap">{{ $item->rencanaProyek->judul_proyek ?? 'Judul Aplikasi' }}</td>
                        <td>
                            <ul class="mb-0 ps-3">
                                @foreach ($item->anggota as $anggota)
                                <li>{{ $anggota->nim }} - {{ $anggota->mahasiswaFK->nama ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $item->manpro ?? '-' }}</td>
                        <td>{{ $item->kelas ?? '-' }}</td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">{{ $item->progress_percent }}%</span>
                                <div class="progress w-100">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $item->progress_percent }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    {{-- End of Riwayat Tim PBL --}}

    {{-- Data Dosen --}}
    <div class="card mt-4">
        <div class="card-header pb-0 p-3">
            <div class="d-flex justify-content-between">
                <h6 class="mb-2">Data Terbaru Dosen Pengampu Mata Kuliah atau Manpro</h6>
            </div>
        </div>
        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-basic">
                <thead class="table-light">
                    <tr>
                        <th>Kode Matkul</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Nama Dosen</th>
                        <th>NIP/NIK/NIPPPK</th>
                        <th>Status</th>
                        <th>Kelas yang Diampu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datadosen as $index => $item)
                    <tr>
                        <td>{{ $item->matkulFK->kode ?? '-' }}</td>
                        <td>{{ $item->matkulFK->matakuliah ?? '-' }}</td>
                        <td>{{ $item->dosenFk->nama ?? '-' }}</td>
                        <td>{{ $item->dosenFk->nip ?? '-' }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->kelasFk->kelas ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- End of Data Dosen --}}
    {{-- End of Tabel Dashboard --}}
</div>
@endsection
