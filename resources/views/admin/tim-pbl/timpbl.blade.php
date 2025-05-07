@extends('layouts.dashboardadmin-template')

@section('title', 'Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Tim PBL')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Daftar Tim PBL</h4>
            <a href="{{ route('admin.timpbl.tambah') }}" class="btn btn-primary fw-bold">
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
                        <th>Manajer Proyek</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timPBL as $index => $tim)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $tim->id_tim }}</td>
                        <td>{{ $tim->ketua->nim }} - {{ $tim->ketua->nama }}</td>
                        <td>Semester {{ $tim->periode->semester }} / {{ $tim->periode->tahun }}</td>
                        <td>{{ $tim->manajer_proyek->nip }} - {{ $tim->manajer_proyek->nama }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.timpbl.edit', $tim->id_tim) }}"
                                class="btn btn-sm btn-info text-white" aria-label="Edit {{ $tim->kode_tim }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $tim->timPBL_encoded }}" action="{{ route('admin.timpbl.delete', $tim->id_tim) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete('{{ $tim->timPBL_encoded }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
{{-- Script Konfirmasi Hapus Data --}}
<script>
    function confirmDelete(encodedTimPBL) {
    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + encodedTimPBL).submit();
        }
    });
}
</script>
@endpush
