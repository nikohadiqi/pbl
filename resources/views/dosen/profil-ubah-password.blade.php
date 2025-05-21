@extends('layouts.dashboarddosen-template')

@section('title','Ubah Password | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Ubah Password')
@section('page-title-1', 'Profil')
@section('page-title-1-url', route('dosen.profil'))
@section('content')
<div class="container-fluid my-5 py-2">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-body">
                <h5 class="mb-3">Form Ubah Password</h5>
                 {{-- Tampilkan error validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- Tampilkan pesan error dari controller --}}
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ route('dosen.profil.update-password') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Password Lama</label>
                        <input type="password" name="old_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
