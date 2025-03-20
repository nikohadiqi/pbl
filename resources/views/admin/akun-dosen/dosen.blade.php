@extends('layouts.dashboardadmin-template')

@section('title','Akun Dosen | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Akun Dosen</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.tambah-dosen') }}">
                    <button class="btn btn-primary text-white fw-bold"><i class="bi bi-plus me-2"></i>Tambah Data</button>
                </a>
                <a href="#">
                    <button class="btn btn-primary text-white fw-bold"><i class="bi bi-upload me-2"></i>Impor Data</button>
                </a>
            </div>
        </div>
        <p class="text-muted">Akun Dosen yang digunakan dalam sistem</p>

        {{-- Menampilkan pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive mt-3">
            <table class="table table-hover" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Dosen</th>
                        <th>NIP/NIK/NIPPPK</th>
                        <th>No Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dosen as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->nip }}</td>
                        <td>{{ $data->no_telp}}</td>
                        <td>
                            <a href="{{ route('admin.edit-dosen', $data->id) }}">
                                <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                            </a>
                            <form action="{{ route('admin.dosen.delete', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data dosen</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
