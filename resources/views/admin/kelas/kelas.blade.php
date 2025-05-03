@extends('layouts.dashboardadmin-template')

@section('title','Data Kelas | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Kelas')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Data Kelas</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.tambah-kelas') }}" class="btn btn-primary text-white fw-bold">
                    <i class="bi bi-plus me-2"></i>Tambah Data
                </a>
            </div>
        </div>
        <p class="text-sm">Data Kelas Program Studi Teknologi Rekayasa Perangkat Lunak - JBI Poliwangi</p>

        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th class="text-center">Nomor</th>
                        <th>Kelas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-weight-normal">
                    @foreach ($kelas as $index => $object)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $object->kelas }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.edit-kelas', $object->kelas) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form id="delete-form-{{ $object->kelas_encoded }}" action="{{ route('admin.delete-kelas', $object->kelas) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger text-white" title="Hapus" onclick="confirmDelete('{{ $object->kelas_encoded }}')">
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
    function confirmDelete(encodedKelas) {
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
            document.getElementById('delete-form-' + encodedKelas).submit();
        }
    });
}
</script>
@endpush
