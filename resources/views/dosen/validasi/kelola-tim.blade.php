@extends('layouts.dashboarddosen-template')

@section('title', 'Kelola Tim PBL')
@section('page-title', 'Kelola Tim PBL: ' . $tim->kode_tim)

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4 shadow-sm">
        <h5 class="fw-bold text-dark mb-3">Kelola Tim PBL</h5> <!-- Ubah di sini -->

        <div class="table-responsive">
            <table class="table align-middle table-hover table-borderless border border-light shadow-sm rounded-3 overflow-hidden">
                <thead class="text-sm fw-semibold text-white bg-primary">
                    <tr>
                        <th style="width: 20%">NIM</th>
                        <th style="width: 30%">Nama</th>
                        <th style="width: 50%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tim->anggota as $anggota)
                    <tr>
                        <td>{{ $anggota->nim }}</td>
                        <td>{{ $anggota->mahasiswaFK->nama ?? '-' }}</td>
                    <td>
                        <div class="d-flex flex-wrap align-items-center">
                            {{-- Reset Password --}}
                            <form method="POST" action="{{ route('dosen.validasi-tim.reset-password', [$tim->kode_tim, $anggota->nim]) }}" class="d-flex align-items-center me-4 mb-2">
                                @csrf
                                <input type="password" name="password" class="form-control form-control-sm me-2 w-auto" placeholder="New Password" required>
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="bi bi-key"></i> Reset
                                </button>
                            </form>

                            {{-- Hapus Anggota --}}
                            <form method="POST" action="{{ route('dosen.validasi-tim.hapus-anggota', [$tim->kode_tim, $anggota->nim]) }}" class="mb-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus anggota ini?')">
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
                                <input type="text" name="nim" class="form-control form-control-sm" placeholder="NIM Mahasiswa" required>
                            </td>
                            <td>
                                <input type="password" name="password" class="form-control form-control-sm" placeholder="Password Default" required>
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
