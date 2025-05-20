@extends('layouts.dashboardadmin-template')

@section('title', 'Dosen Pengampu MK / Manpro | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Dosen Pengampu MK / Manpro')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Daftar Dosen Pengampu Mata Kuliah / Manajer Proyek</h4>
            <a href="{{ route('admin.pengampu.tambah') }}" class="btn btn-primary fw-bold">
                <i class="bi bi-plus me-2"></i>Tambah Data
            </a>
        </div>
        <p class="text-sm">Pengaturan Dosen sebagai Manajer Proyek atau Dosen Pengampu Mata Kuliah</p>

        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Mata Kuliah</th>
                        <th>Nama Dosen</th>
                        <th>Status</th>
                        <th>Kelas yang Diampu</th>
                        <th>Periode PBL</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengampus as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->matkulFK->kode ?? '-' }} <br> {{ $item->matkulFK->matakuliah ?? '-' }}</td>
                        <td>{{ $item->dosenFk->nip ?? '-' }} <br> {{ $item->dosenFk->nama ?? '-' }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->kelasFk->kelas ?? '-' }}</td>
                        <td>Semester {{ $item->periodeFK->semester ?? '-' }} <br>Tahun {{ $item->periodeFK->tahun ?? '-' }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.pengampu.edit', $item->id) }}">
                                    <button class="btn btn-sm btn-info text-white" title="Ubah">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $item->id }}"
                                    action="{{route('admin.pengampu.delete', $item->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger text-white"
                                        onclick="confirmDelete({{ $item->id }})" title="Hapus">
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
