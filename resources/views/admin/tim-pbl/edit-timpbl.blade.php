@extends('layouts.dashboardadmin-template')

@section('title','Ubah Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Ubah Data Tim PBL')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="ketua-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Ubah Data Tim PBL</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
        <form action="{{ route('admin.timpbl.update', $timPBL->id_tim) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- ID Tim (Read Only) -->
            <div class="form-group mb-3">
                <label for="id_tim">ID Tim Proyek</label>
                <input type="text" name="id_tim" class="form-control @error('id_tim') is-invalid @enderror"
                    value="{{ old('id_tim', $timPBL->id_tim) }}" readonly>
                @error('id_tim')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Ketua Tim (Search by NIM/Nama) -->
            <div class="form-group">
                <label for="ketua_tim" class="form-control-label">Ketua Tim</label>
                <select name="ketua_tim" class="form-control select2">
                    <option value="" disabled selected hidden>Pilih Mahasiswa Sebagai Ketua Tim</option>
                    @foreach($ketuaTim as $ketua)
                        <option value="{{ $ketua->nim }}" {{ (old('ketua_tim', $timPBL->ketua_tim ?? '') == $ketua->nim) ? 'selected' : '' }}>
                            {{ $ketua->nim }} - {{ $ketua->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Periode -->
            <div class="form-group">
                <label for="periode_id">Periode PBL</label>
                <select class="form-control" id="periode_id" name="periode_id">
                    <option value="" disabled selected hidden>Pilih Periode PBL</option>
                    @foreach($periode as $periodepbl)
                    <option value="{{ $periodepbl->id }}" {{ old('periode_id', $timPBL->periode_id) == $periodepbl->id ?
                        'selected' : '' }}>
                        Semester {{ $periodepbl->semester }} - {{ $periodepbl->tahun }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Manpro --}}
            <div class="form-group">
                <label for="manpro">Manajer Proyek</label>
                <select class="form-control" id="manpro" name="manpro" required>
                    <option value="" disabled hidden>Pilih Manajer Proyek</option>
                    @foreach($manpro as $dosen)
                    <option value="{{ $dosen->nip }}" {{ $timPBL->manpro == $dosen->nip ? 'selected' : '' }}>
                        {{ $dosen->nama }}
                    </option>
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
