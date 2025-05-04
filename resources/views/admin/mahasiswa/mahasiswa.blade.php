@extends('layouts.dashboardadmin-template')

@section('title','Data Mahasiswa | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Data Mahasiswa')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Data Mahasiswa</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.mahasiswa.tambah') }}" class="btn btn-primary text-white fw-bold">
                    <i class="bi bi-plus me-2"></i>Tambah Data
                </a>
                <form id="import-form" action="{{ route('admin.mahasiswa.import') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                    @csrf
                    <input type="file" id="import-file" name="file" accept=".xlsx,.xls,.csv" onchange="document.getElementById('import-form').submit();">
                </form>
                <!-- Tombol Trigger -->
                <button class="btn btn-primary text-white fw-bold" onclick="document.getElementById('import-file').click();">
                    <i class="bi bi-upload me-2"></i>Impor Data
                </button>
            </div>
        </div>
        <p class="text-sm">Data Mahasiswa Program Studi Teknologi Rekayasa Perangkat Lunak - JBI Poliwangi</p>

        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>Prodi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-weight-normal">
                    @foreach ($mahasiswa as $index => $mhs)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $mhs->kelas }}</td>
                        <td>{{ $mhs->program_studi }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.mahasiswa.edit', $mhs->nim) }}" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $mhs->nim }}" action="{{route('admin.mahasiswa.delete', $mhs->nim)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete({{ $mhs->nim }})">
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
    function confirmDelete(nim) {
        console.log(nim);
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
            document.getElementById('delete-form-' + encodeURIComponent(nim)).submit();
        }
    })
}
</script>
@endpush
