@extends('layouts.dashboarddosen-template')

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
                                <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                    <img src="{{ url('assets/img/logo-poliwangi.png') }}" alt="bruce"
                                        class="w-100 border-radius-lg shadow-sm">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto col-8 my-auto">
                        <div class="h-100">
                            <h5 class="mb-1 font-weight-bolder">
                                Dosen
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                {{ Auth::guard('dosen')->user()->nim }}
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                        {{-- This section can be used for future functionality (e.g., switching visibility) --}}
                    </div>
                </div>
            </div>

            <!-- Card Basic Info -->
            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Informasi User</h5>
                </div>
                <div class="card-body pt-0">
                    <!-- Informasi dasar -->
                    <div class="form-group">
                        <label for="nip" class="form-control-label">NIP/NIK/NIPPPK</label>
                        <input class="form-control" name="nip" type="text" value="{{ $dosen->nip ?? '-' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="form-control-label">Nama</label>
                        <input class="form-control" name="nama" type="text" value="{{ $dosen->nama ?? '-' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="role" class="form-control-label">Role</label>
                        <input class="form-control" name="role" type="text" value="{{ $akun->role }}" readonly>
                    </div>
                    <hr class="horizontal dark">
                    <!-- Informasi Pengampu -->
                    <h6 class="mt-4">Informasi Dosen Pengampu</h6>
                    @forelse ($pengampuFK as $pengampu)
                    <div class="card mb-2 p-3 border">
                        <p><strong>Kelas:</strong> {{ $pengampu->kelasFk->kelas ?? '-' }}</p>
                        <p><strong>Mata Kuliah:</strong> {{ $pengampu->matkulFK->kode ?? '-' }} - {{ $pengampu->matkulFK->matakuliah ?? '-' }} </p>
                        <p><strong>Status Pengampu:</strong> {{ $pengampu->status }}</p>
                        <p><strong>Periode PBL:</strong> Semester {{ $pengampu->periodeFK->semester }} / {{ $pengampu->periodeFK->tahun }}</p>
                    </div>
                    @empty
                    <p class="text-muted">Belum mengampu kelas apapun.</p>
                    @endforelse
                    <a href="{{ route('dosen.profil.ubah-password') }}"
                        class="btn btn-primary text-white fw-bold float-end mt-3 mb-1"><i class="bi-pencil-square me-1"></i> Ubah Password Disini</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
