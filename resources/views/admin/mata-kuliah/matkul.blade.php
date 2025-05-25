@extends('layouts.dashboardadmin-template')

@section('title','Mata Kuliah | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Mata Kuliah')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Mata Kuliah</h4>
            <a href="{{ route('admin.matkul.tambah') }}">
                <button class="btn btn-primary text-white fw-bold"><i class="bi bi-plus me-2"></i>Tambah Data</button>
            </a>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <p class="text-sm">Data Mata Kuliah Prodi TRPL yang merupakan Mata Kuliah PBL</p>
        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th>Nomor</th>
                        <th>Kode Matkul</th>
                        <th>Mata Kuliah</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-weight-normal">
                    @foreach($matkul as $index => $mataKuliah)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mataKuliah->kode }}</td>
                        <td>{{ $mataKuliah->matakuliah }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.matkul.edit', $mataKuliah->id) }}">
                                    <button class="btn btn-sm btn-info text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah" data-container="body" data-animation="true"><i class="bi bi-pencil-square"></i></button>
                                </a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $mataKuliah->id }}" action="{{route('admin.matkul.delete', $mataKuliah->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete({{ $mataKuliah->id }})" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" data-container="body" data-animation="true">
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
