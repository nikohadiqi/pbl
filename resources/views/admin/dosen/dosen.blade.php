@extends('layouts.dashboardadmin-template')

@section('title','Data Dosen | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Data Dosen')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Data Dosen</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dosen.tambah') }}">
                    <button class="btn btn-primary text-white fw-bold"><i class="bi bi-plus me-2"></i>Tambah Data</button>
                </a>
                <form id="import-form" action="{{ route('admin.dosen.import') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                    @csrf
                    <input type="file" id="import-file" name="file" accept=".xlsx,.xls,.csv" onchange="document.getElementById('import-form').submit();">
                </form>
                <!-- Tombol Trigger -->
                <button class="btn btn-primary text-white fw-bold" onclick="document.getElementById('import-file').click();">
                    <i class="bi bi-upload me-2"></i>Impor Data
                </button>
            </div>
        </div>
        <p class="text-sm">Data Dosen Program Studi Teknologi Rekayasa Perangkat Lunak - JBI Poliwangi</p>

        {{-- Menampilkan pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th>Nomor</th>
                        <th>NIP/NIK/NIPPPK</th>
                        <th>Nama Dosen</th>
                        <th>No Telp</th>
                        <th>Email</th>
                        {{-- <th>Prodi</th>
                        <th>Jurusan</th> --}}
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-weight-normal">
                    @forelse($dosen as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->nip }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->no_telp}}</td>
                        <td>{{ $data->email}}</td>
                        {{-- <td>{{ $data->prodi}}</td>
                        <td>{{ $data->jurusan}}</td> --}}
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.dosen.edit', $data->nip) }}">
                                    <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></button>
                                </a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $data->nip }}" action="{{route('admin.dosen.delete', $data->nip)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete({{ $data->nip }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data dosen</td>
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
    function confirmDelete(nip) {
        console.log(nip);
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
            document.getElementById('delete-form-' + encodeURIComponent(nip)).submit();
        }
    })
}
</script>
@endpush
