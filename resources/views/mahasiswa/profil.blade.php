@extends('layouts.dashboardmahasiswa-template')

@section('title','Profil | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Profil')
@section('content')
<div class="container-fluid my-5 py-2">
    <div class="d-flex justify-content-center mb-5">
        <div class="col-lg-9 mt-lg-0 mt-4">
            <!-- Card Profile -->
            <div class="card card-body" id="profile">
                <div class="row justify-content-center">
                    <div class="col-sm-auto col-4">
                        <div class="avatar avatar-xl position-relative">
                            <div>
                                {{-- <label for="file-input"
                                    class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                    <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                        aria-hidden="true" data-bs-original-title="Edit Image"
                                        aria-label="Edit Image"></i>
                                    <span class="sr-only">Edit Image</span>
                                </label> --}}

                                <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                    <img src="{{ asset('assets/img/logo-poliwangi.png') }}" alt="bruce"
                                        class="w-100 border-radius-lg shadow-sm">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto col-8 my-auto">
                        <div class="h-100">
                            <h5 class="mb-1 font-weight-bolder">
                                Mahasiswa
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                {{ Auth::guard('mahasiswa')->user()->nim }}
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                        {{-- <label class="form-check-label mb-0">
                            <small id="profileVisibility">
                                Switch to invisible
                            </small>
                        </label>
                        <div class="form-check form-switch ms-2">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault23" checked=""
                                onchange="visible()">
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Card Basic Info -->
            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Informasi User</h5>
                </div>
                <div class="card-body pt-0">
                    <!-- Informasi Dasar -->
                    <div class="form-group">
                        <label for="nip" class="form-control-label">NIM</label>
                        <input class="form-control" name="nip" type="text" value="{{ $mahasiswa->nim ?? '-' }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="form-control-label">Nama</label>
                        <input class="form-control" name="nama" type="text" value="{{ $mahasiswa->nama ?? '-' }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="role" class="form-control-label">Role</label>
                        <input class="form-control" name="role" type="text" value="{{ $akun->role }}" readonly>
                    </div>

                    <!-- Informasi Tim -->
                    <hr class="horizontal dark">
                    <h6 class="mt-4">Informasi Tim</h6>
                    <div class="card mb-2 p-3 border">
                        <p><strong>Kode Tim:</strong> {{ $akun->kode_tim ?? '-' }}</p>
                        <p><strong>Kelas:</strong> {{ $mahasiswa->kelas ?? '-' }}</p>
                        <p><strong>Manajer Proyek:</strong> {{ $timPbl->manproFk->nama ?? '-' }}</p>
                    </div>

                    <a href="{{ route('mahasiswa.profil.ubah-password') }}"
                        class="btn btn-primary text-white fw-bold float-end mt-3 mb-1">Ubah Password Disini</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
