@extends('layouts.dashboardadmin-template')

@section('title','Mata Kuliah | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Mata Kuliah</h4>
            <a href="{{ route('admin.tambah-matkul') }}">
                <button class="btn btn-primary text-white fw-bold"><i class="bi bi-plus me-2"></i>Tambah Data</button>
            </a>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <p class="text-muted">Data Mata Kuliah Prodi TRPL</p>
        <div class="table-responsive mt-3">
            <table class="table table-hover" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th>Nomor</th>
                        <th>Mata Kuliah</th>
                        <th>Capaian</th>
                        <th>Tujuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $matkul)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $matkul->matakuliah }}</td>
                        <td>{{ $matkul->capaian }}</td>
                        <td>{{ $matkul->tujuan }}</td>
                        <td>
                            <a href="{{ route('admin.edit-matkul', $matkul->id) }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <form action="{{ route('admin.hapus-matkul', $matkul->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
