@extends('layouts.dashboardadmin-template')

@section('title', 'Tahapan Pelaksanaan Semester 5 | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Tahapan Pelaksanaan Semester 5')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Tahapan Pelaksanaan Proyek - Semester 5</h4>
            <a href="{{ route('admin.tahapanpelaksanaan-sem5.tambah') }}" class="btn btn-primary fw-bold">
                <i class="bi bi-plus me-2"></i>Tambah Data
            </a>
        </div>
        <p class="text-sm">Daftar tahapan pelaksanaan proyek semester 5</p>

        <div class="table-responsive mt-3">
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
                            <a href="{{ route('admin.tahapanpelaksanaan-sem5.edit', $item->id) }}"
                               class="btn btn-sm btn-info text-white" aria-label="Edit {{ $item->tahapan }}" title="Ubah">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- Delete Button -->
                            <form id="delete-form-{{ $item->id }}"
                                action="{{route('admin.tahapanpelaksanaan-sem5.delete', $item->id)}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger text-white"
                                    onclick="confirmDelete({{ $item->id }})" title="Hapus">
                                    <i class="bi bi-trash"></i>
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

@push('script')
{{-- Script Konfirmasi Hapus Data --}}
<script>
    function confirmDelete(id) {
        console.log(id);
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
            // Submit form delete
            document.getElementById('delete-form-' + encodeURIComponent(id)).submit();
        }
    })
}
</script>
@endpush
