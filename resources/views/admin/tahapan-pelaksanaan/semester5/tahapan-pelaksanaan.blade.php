@extends('layouts.dashboardadmin-template')

@section('title', 'Tahapan Pelaksanaan Semester 5')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Tahapan Pelaksanaan Proyek - Semester 5</h4>
            <a href="{{ route('admin.tambah-tahapanpelaksanaan-sem5') }}" class="btn btn-primary fw-bold">
                <i class="bi bi-plus me-2"></i>Tambah Data
            </a>
        </div>
        <p class="text-sm">Daftar tahapan pelaksanaan proyek semester 5</p>

        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Tahapan</th>
                        <th>PIC</th>
                        <th>Score (%)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tahapan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->tahapan }}</td>
                        <td>{{ $item->pic }}</td>
                        <td>{{ $item->score }}%</td>
                        <td>
                            <a href="{{ route('admin.edit-tahapanpelaksanaan-sem5', $item->id) }}"
                               class="btn btn-sm btn-info text-white" aria-label="Edit {{ $item->tahapan }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.tahapanpelaksanaan.delete', $item->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data {{ $item->tahapan }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" aria-label="Hapus {{ $item->tahapan }}">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data tahapan pelaksanaan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
