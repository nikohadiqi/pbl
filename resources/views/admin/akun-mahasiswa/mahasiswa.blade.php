@extends('layouts.dashboardadmin-template')

@section('title','Akun Mahasiswa | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Akun Mahasiswa</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.tambah-mahasiswa') }}" class="btn btn-primary text-white fw-bold">
                    <i class="bi bi-plus me-2"></i>Tambah Data
                </a>
                <a href="#" class="btn btn-primary text-white fw-bold">
                    <i class="bi bi-upload me-2"></i>Impor Data
                </a>
            </div>
        </div>
        <p class="text-sm">Akun Mahasiswa yang digunakan dalam sistem ke proyek PBL masing-masing</p>

        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light font-weight-bold">
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-weight-normal">
                    @foreach ($mahasiswa as $index => $mhs)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->kelas }}</td>
                        <td>
                            <a href="{{ route('admin.edit-mahasiswa', $mhs->nim) }}" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $mhs->nim }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-form-{{ $mhs->nim }}" action="{{ route('admin.delete-mahasiswa', ['nim' => $mhs->nim]) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmDelete(nim) {
        if (confirm("Apakah Anda yakin ingin menghapus mahasiswa ini?")) {
            document.getElementById('delete-form-' + nim).submit();
        }
    }
</script>

@endsection
