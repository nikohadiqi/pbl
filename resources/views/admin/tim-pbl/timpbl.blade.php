@extends('layouts.dashboardadmin-template')

@section('title', 'Tim PBL')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Daftar Tim PBL</h4>
            <a href="{{ route('admin.tambah-timpbl') }}" class="btn btn-primary fw-bold">
                <i class="bi bi-plus me-2"></i>Tambah Tim
            </a>
        </div>
        <p class="text-sm">Daftar tim yang terdaftar dalam sistem PBL</p>

        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>ID Tim</th>
                        <th>Kode Tim</th>
                        <th>Ketua Tim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($timPBL as $index => $tim)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $tim->id }}</td>
                        <td>{{ $tim->kode_tim }}</td>
                        <td>{{ $tim->ketua->nama ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.edit-timpbl', $tim->id) }}"
                               class="btn btn-sm btn-info text-white" aria-label="Edit {{ $tim->kode_tim }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.timpbl.delete', $tim->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus tim {{ $tim->kode_tim }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" aria-label="Hapus {{ $tim->kode_tim }}">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data tim PBL.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $timPBL->links() }}
        </div>
    </div>
</div>
@endsection
