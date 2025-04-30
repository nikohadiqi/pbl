@extends('layouts.dashboardadmin-template')

@section('title','Edit Periode PBL | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Edit Data Periode PBL</h5>
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

        <!-- Form Edit Periode PBL -->
        <form class="mt-1" method="POST" action="{{ route('admin.periodepbl.update', $periode->id) }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="semester" class="form-control-label">Semester Pelaksanaan PBL</label>
                <select class="form-control" id="semester" name="semester" required>
                    <option disabled>Pilih Semester</option>
                    <option value="4" {{ $periode->semester == 4 ? 'selected' : '' }}>Semester 4</option>
                    <option value="5" {{ $periode->semester == 5 ? 'selected' : '' }}>Semester 5</option>
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="tahun_pelaksanaan" class="form-control-label">Tahun Pelaksanaan PBL</label>
                <input class="form-control" placeholder="Masukan Tahun Periode Pelaksanaan PBL" type="text" name="tahun" value="{{ $periode->tahun }}" required>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                <a href="{{ route('admin.periodepbl') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
