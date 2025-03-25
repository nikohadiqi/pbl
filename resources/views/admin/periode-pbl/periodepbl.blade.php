@extends('layouts.dashboardadmin-template')

@section('title', 'Periode PBL | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Data Periode PBL</h4>
            <a href="{{ route('admin.tambah-periodepbl') }}">
                <button class="btn btn-primary text-white fw-bold">
                    <i class="bi bi-plus me-2"></i>Tambah Data
                </button>
            </a>
        </div>
        <p class="text-muted">Periode Pengerjaan Proyek PBL Mahasiswa Prodi TRPL</p>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th>Nomor</th>
                        <th>Semester</th>
                        <th>Tahun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-weight-normal">
                    @foreach($periodePBL as $key => $periode)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>Semester {{ $periode->semester }}</td>
                            <td>{{ $periode->tahun }}</td>
                            <td>
                                <a href="{{ route('admin.edit-periodepbl', $periode->id) }}">
                                    <button class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </a>
                                <form action="{{ route('admin.periodepbl.delete', $periode->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
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
