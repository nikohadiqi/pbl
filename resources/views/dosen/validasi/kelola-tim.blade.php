@extends('layouts.dashboarddosen-template')

@section('title','Kelola Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Kelola Tim PBL')
@section('page-title-1', 'Validasi Tim PBL')
@section('page-title-1-url', route('dosen.validasi-tim'))
@section('content')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Kelola Tim {{ $tim->kode_tim }}</h4>
        </div>
        <p class="text-sm">Mengelola Anggota dari Tim {{ $tim->kode_tim }} - Sistem Informasi dan Monitoring Project Based Learning</p>

        <div class="table-responsive mt-3">
            <table class="table align-middle table-hover table-bordered shadow-sm rounded-3 overflow-hidden">
                <thead class="text-sm fw-semibold text-white bg-primary">
                    <tr>
                        <th style="width: 30%">NIM</th>
                        <th>Nama</th>
                        <th style="width: 30%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tim->anggota as $anggota)
                    <tr>
                        <td>{{ $anggota->nim }}</td>
                        <td>{{ $anggota->mahasiswaFK->nama ?? '-' }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Reset Password --}}
                                <form id="form-reset-{{ $anggota->nim }}" method="POST"
                                    action="{{ route('dosen.validasi-tim.reset-password', [$tim->kode_tim, $anggota->nim]) }}"
                                    class="d-inline me-2 mb-2">
                                    @csrf
                                    <button type="button" class="btn btn-warning btn-sm btn-reset"
                                        data-nim="{{ $anggota->nim }}">
                                        <i class="bi bi-key"></i> Reset Password
                                    </button>
                                </form>
                                {{-- Hapus Anggota --}}
                                <form id="form-delete-{{ $anggota->nim }}" method="POST"
                                    action="{{ route('dosen.validasi-tim.hapus-anggota', [$tim->kode_tim, $anggota->nim]) }}"
                                    class="d-inline mb-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                        data-nim="{{ $anggota->nim }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Belum ada anggota yang terdaftar.</td>
                    </tr>
                    @endforelse

                    {{-- Form Tambah Anggota --}}
                    <tr>
                        <form method="POST" action="{{ route('dosen.validasi-tim.tambah-anggota', $tim->kode_tim) }}">
                            @csrf
                            <td>
                                <select name="nim" class="form-select select2" required>
                                    <option value="" disabled selected hidden>Pilih Mahasiswa</option>
                                    @foreach($mahasiswa as $mhs)
                                    <option value="{{ $mhs->nim }}">
                                        {{ $mhs->nim }} - {{ $mhs->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-muted">
                                Password sama dengan NIM
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Tambah Anggota
                                </button>
                            </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('css')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
    rel="stylesheet" />
<style>
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #dee2e6 !important;
        border-radius: 0.5rem !important;
        padding: 0.5rem 1rem !important;
        font-size: 0.875rem;
        height: auto !important;
        transition: all 0.2s ease-in-out;
        position: relative;
        z-index: 1050;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #dfa02c !important;
        box-shadow: 0 0 0 2px rgba(247, 205, 7, 0.1);
        outline: none;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid #dfa02c !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 4px 10px rgba(247, 205, 7, 0.1);
        margin-top: 2px;
        overflow: hidden;
    }

    .select2-container--bootstrap-5.select2-container--above .select2-dropdown {
        margin-top: 0;
        margin-bottom: 2px;
    }

    .select2-container--bootstrap-5 .select2-selection__rendered {
        line-height: 1.5 !important;
        padding-left: 0 !important;
    }

    .select2-container--bootstrap-5 .select2-selection__arrow {
        top: 50% !important;
        transform: translateY(-50%);
        right: 1rem;
        position: absolute;
    }
</style>
@endpush

@push('script')
<!-- jQuery (required by Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Mahasiswa',
        });
    });
</script>

<script>
    document.querySelectorAll('.btn-reset').forEach(button => {
        button.addEventListener('click', function () {
            const nim = this.dataset.nim;
            Swal.fire({
                title: 'Reset Password?',
                text: 'Password akan direset menjadi NIM.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`form-reset-${nim}`).submit();
                }
            });
        });
    });

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            const nim = this.dataset.nim;
            Swal.fire({
                title: 'Hapus Anggota?',
                text: 'Data anggota akan dihapus dari tim.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`form-delete-${nim}`).submit();
                }
            });
        });
    });
</script>

@endpush
