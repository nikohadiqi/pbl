@extends('layouts.dashboardadmin-template')

@section('title', 'Tambah Mata Kuliah')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <h5 class="fw-bold">Tambah Data Mata Kuliah</h5>
        <p class="text-muted">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
    </div> <!-- ✅ Menutup div card yang terbuka -->

    <div class="card p-4 mt-3"> <!-- ✅ Menambah card untuk form agar rapi -->
        <form action="{{ route('admin.matkul.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="matakuliah">Mata Kuliah</label>
                <input class="form-control" type="text" name="matakuliah" placeholder="Masukkan Nama Mata Kuliah" required>
            </div>
            <div class="form-group">
                <label for="capaian">Capaian</label>
                <textarea class="form-control" name="capaian" rows="5" placeholder="Masukkan Capaian Mata Kuliah" required></textarea>
            </div>
            <div class="form-group">
                <label for="tujuan">Tujuan</label>
                <textarea class="form-control" name="tujuan" rows="5" placeholder="Masukkan Tujuan Mata Kuliah" required></textarea>
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
    </div> <!-- ✅ Menutup div card baru -->
</div>
@endsection
