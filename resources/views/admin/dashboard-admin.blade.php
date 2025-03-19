@extends('layouts.dashboardadmin-template')

@section('title','Dashboard Admin | Sistem Informasi dan Monitoring Project Based Learning')

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
                                    70
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
                                    350
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
                                    30
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
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Tim</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Judul Proyek PBL
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kelas</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Progres Proyek
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-xs font-weight-bold">3A_1</td>
                        <td class="text-xs font-weight-bold">Aplikasi 1</td>
                        <td class="text-xs font-weight-bold">3A</td>
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
                        <td class="text-xs font-weight-bold">3A_2</td>
                        <td class="text-xs font-weight-bold">Aplikasi 2</td>
                        <td class="text-xs font-weight-bold">3A</td>
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
                        <td class="text-xs font-weight-bold">3A_3</td>
                        <td class="text-xs font-weight-bold">Web apps</td>
                        <td class="text-xs font-weight-bold">3A</td>
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
                        <td class="text-xs font-weight-bold">3A_4</td>
                        <td class="text-xs font-weight-bold">Web App</td>
                        <td class="text-xs font-weight-bold">3A</td>
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
                        <td class="text-xs font-weight-bold">3A_5</td>
                        <td class="text-xs font-weight-bold">Web Apps</td>
                        <td class="text-xs font-weight-bold">3A</td>
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
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Dosen</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mengampu
                            Mata Kuliah</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            NIP/NIK</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No
                            Telp</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-x font-weight-bold">Mohamad Dimyati Ayatullah, S.T., M.Kom.</td>
                        <td class="text-x">Proyek Aplikasi Dasar</td>
                        <td class="text-x">197601222021211000</td>
                        <td class="text-x">08123399184</td>
                    </tr>
                    <tr>
                        <td class="text-x font-weight-bold">Dianni Yusuf, S.Kom., M.Kom.</td>
                        <td class="text-x">Basis Data</td>
                        <td class="text-x">198403052021212000</td>
                        <td class="text-x">082328333999</td>
                    </tr>
                    <tr>
                        <td class="text-x font-weight-bold">I Wayan Suardinata, S.Kom., M.T.</td>
                        <td class="text-x">ADPL</td>
                        <td class="text-x">198010222015041000</td>
                        <td class="text-x">085736577864</td>
                    </tr>
                    <tr>
                        <td class="text-x font-weight-bold">Eka Mistiko Rini, S.Kom, M.Kom.</td>
                        <td class="text-x">Basis Data</td>
                        <td class="text-x">198310202014042001</td>
                        <td class="text-x">081913922224</td>
                    </tr>
                    <tr>
                        <td class="text-x font-weight-bold">Ruth Ema Febrita, S.Pd., M.Kom.</td>
                        <td class="text-x">Proyek Aplikasi Dasar</td>
                        <td class="text-x">199202272020122000</td>
                        <td class="text-x">085259082627</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    {{-- End of Data Dosen --}}
    {{-- End of Tabel Dashboard --}}
</div>
@endsection
