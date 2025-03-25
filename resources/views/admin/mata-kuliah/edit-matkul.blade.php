@extends('layouts.dashboardadmin-template')

@section('title','Edit Mata Kuliah | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <h5 class="fw-bold">Edit Data Mata Kuliah</h5>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
        <form action="{{ route('admin.update-matkul', $matkul->id) }}" method="POST">
    @csrf
    @method('PATCH')  {{-- Gantilah PUT dengan PATCH --}}
    
    <div class="form-group">
        <label for="matakuliah">Mata Kuliah</label>
        <textarea class="form-control" name="matakuliah" rows="5" required>{{ $matkul->matakuliah }}</textarea>
        </div>
    <div class="form-group">
        <label for="capaian">Capaian</label>
        <textarea class="form-control" name="capaian" rows="5" required>{{ $matkul->capaian }}</textarea>
    </div>
    <div class="form-group">
        <label for="tujuan">Tujuan</label>
        <textarea class="form-control" name="tujuan" rows="5" required>{{ $matkul->tujuan }}</textarea>
    </div>
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">Perbarui Data</button>
    </div>
</form>
    </div>
</div>
@endsection
