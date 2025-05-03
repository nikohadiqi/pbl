@extends('layouts.dashboardadmin-template')

@section('title', 'Tambah Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Tambah Data Tim PBL')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <h5 class="fw-bold">Tambah Tim PBL</h5>
        <p class="text-sm">Tambahkan tim baru dalam sistem PBL</p>

        <form action="{{ route('admin.timpbl.store') }}" method="POST">
            @csrf

            <!-- ID Tim (Manual Input) -->
            <div class="form-group mb-3">
                <label for="id_tim">ID Tim Proyek</label>
                <input type="text" name="id_tim" class="form-control @error('id_tim') is-invalid @enderror"
                       placeholder="Masukkan ID Tim" value="{{ old('id_tim') }}" required>
                @error('id_tim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Cari Ketua Tim berdasarkan NIM/Nama --}}
            <div class="form-group">
                <label for="ketua_tim" class="form-control-label">Ketua Tim</label>
                <select name="ketua_tim" class="form-control select2">
                    <option value="" disabled selected hidden>Pilih Mahasiswa Sebagai Ketua Tim</option>
                    @foreach($ketuaTim as $ketua)
                        <option value="{{ $ketua->nim }}">{{ $ketua->nim }} - {{ $ketua->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Periode PBL --}}
            <div class="form-group">
                <label for="periode_id">Periode PBL</label>
                <select class="form-control" id="periode_id" name="periode_id">
                    <option value="" disabled selected hidden>Pilih Periode PBL</option>
                    @foreach($periode as $periodepbl)
                    <option value="{{ $periodepbl->id }}">Semester {{ $periodepbl->semester }} - {{ $periodepbl->tahun }} </option>
                    @endforeach
                </select>
            </div>

            {{-- Manpro --}}
            <div class="form-group">
                <label for="manpro">Manajer Proyek</label>
                <select class="form-control" id="manpro" name="manpro">
                    <option value="" disabled selected hidden>Pilih Manajer Proyek</option>
                    @foreach($manpro as $dosen)
                    <option value="{{ $dosen->nip }}">{{ $dosen->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
    <!-- Select2 Bootstrap 4 Theme jika belum dimuat -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('script')
<!-- jQuery (required by Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: 'Pilih Mahasiswa Sebagai Ketua Tim',
            allowClear: true
        });
    });
</script>
@endpush
