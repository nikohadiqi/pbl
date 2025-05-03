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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Proyek PBL</p>
                                <h3 class="font-weight-bolder">
                                    {{ $timPBLCount }}
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
                                <i class="ni ni-user-run text-lg opacity-10" aria-hidden="true"></i>
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
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
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
                <h6 class="mb-2">Riwayat Tim PBL</h6>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="datatable-normal">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th>Nama Tim</th>
                        <th>Judul Proyek PBL
                        </th>
                        <th>Kelas</th>
                        <th>Progres Proyek
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="text-xs font-weight-bold">
                    <tr>
                        <td>3A_1</td>
                        <td>Aplikasi 1</td>
                        <td>3A</td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">60%</span>
                                <div class="progress w-100">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 60%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-link text-secondary mb-0">
                                <i class="fa fa-ellipsis-v text-xs"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3A_2</td>
                        <td>Aplikasi 2</td>
                        <td>3A</td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">80%</span>
                                <div class="progress w-100">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 80%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-link text-secondary mb-0">
                                <i class="fa fa-ellipsis-v text-xs"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3A_3</td>
                        <td>Web apps</td>
                        <td>3A</td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">50%</span>
                                <div class="progress w-100">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 50%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-link text-secondary mb-0">
                                <i class="fa fa-ellipsis-v text-xs"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3A_4</td>
                        <td>Web App</td>
                        <td>3A</td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">40%</span>
                                <div class="progress w-100">
                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 40%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-link text-secondary mb-0">
                                <i class="fa fa-ellipsis-v text-xs"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3A_5</td>
                        <td>Web Apps</td>
                        <td>3A</td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">70%</span>
                                <div class="progress w-100">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 70%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-link text-secondary mb-0">
                                <i class="fa fa-ellipsis-v text-xs"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
    {{-- End of Riwayat Tim PBL --}}

    {{-- Data Dosen --}}
    <div class="card mt-4">
        <div class="card-header pb-0 p-3">
            <div class="d-flex justify-content-between">
                <h6 class="mb-2">Data Dosen</h6>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="datatable-basic">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th>Nama Dosen</th>
                        <th>Mengampu
                            Mata Kuliah</th>
                        <th>
                            NIP/NIK</th>
                        <th>No
                            Telp</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-weight-normal">
                    <tr>
                        <td>Mohamad Dimyati Ayatullah, S.T., M.Kom.</td>
                        <td>Proyek Aplikasi Dasar</td>
                        <td>197601222021211000</td>
                        <td>08123399184</td>
                    </tr>
                    <tr>
                        <td>Dianni Yusuf, S.Kom., M.Kom.</td>
                        <td>Basis Data</td>
                        <td>198403052021212000</td>
                        <td>082328333999</td>
                    </tr>
                    <tr>
                        <td>I Wayan Suardinata, S.Kom., M.T.</td>
                        <td>ADPL</td>
                        <td>198010222015041000</td>
                        <td>085736577864</td>
                    </tr>
                    <tr>
                        <td>Eka Mistiko Rini, S.Kom, M.Kom.</td>
                        <td>Basis Data</td>
                        <td>198310202014042001</td>
                        <td>081913922224</td>
                    </tr>
                    <tr>
                        <td>Ruth Ema Febrita, S.Pd., M.Kom.</td>
                        <td>Proyek Aplikasi Dasar</td>
                        <td>199202272020122000</td>
                        <td>085259082627</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    {{-- End of Data Dosen --}}
    {{-- End of Tabel Dashboard --}}
</div>
@endsection
