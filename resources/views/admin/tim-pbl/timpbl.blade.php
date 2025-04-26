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
                        <th>ID Tim Proyek</th>
                        <th>Ketua Tim</th>
                        <th>Periode PBL</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timPBL as $index => $tim)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $tim->id_tim }}</td>
                        <td>{{ $tim->ketua->nim }} - {{ $tim->ketua->nama }}</td>
                        <td>Semester {{ $tim->periode->semester }} / {{ $tim->periode->tahun }}</td>
                        <td>
                            <a href="{{ route('admin.edit-timpbl', $tim->id_tim) }}"
                               class="btn btn-sm btn-info text-white" aria-label="Edit {{ $tim->kode_tim }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.timpbl.delete', $tim->id_tim) }}"
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
