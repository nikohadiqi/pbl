@extends('layouts.dashboardadmin-template')

@section('title', 'Dosen Pengampu MK / Manpro | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Ubah Dosen Pengampu MK atau Manpro')
@section('page-title-1', 'Data Dosen Pengampu')
@section('page-title-1-url', route('admin.pengampu'))
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Ubah Data Pengampu</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Ubah Periode PBL -->
        <form class="mt-1" method="POST" action="{{ route('admin.pengampu.update', $pengampu->id) }}">
            @csrf
            @method('PUT')
            @include('admin.pengampu.form')
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
