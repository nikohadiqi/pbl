@extends('layouts.dashboardadmin-template')

@section('title', 'Tahapan Pelaksanaan Semester 4')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Tahapan Pelaksanaan Proyek - Semester 4</h4>
            <a href="{{ route('admin.tambah-tahapanpelaksanaan-sem4') }}" class="btn btn-primary text-white fw-bold">
                <i class="bi bi-plus me-2"></i>Tambah Data
            </a>
        </div>
        <p class="text-sm">Daftar tahapan pelaksanaan proyek semester 4</p>

        <div class="table-responsive mt-2">
            <table class="table table-hover">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th>No</th>
                        <th>Nama Tahapan</th>
                        <th>PIC</th>
                        <th>Score (%)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tahapan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->tahapan }}</td>
                        <td>{{ $item->pic }}</td>
                        <td>{{ $item->score }}%</td>
                        <td>
                            <a href="{{ route('admin.edit-tahapanpelaksanaan-sem4', $item->id) }}" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>

                            <form action="{{ route('admin.tahapanpelaksanaan-sem4.delete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Hapus
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
