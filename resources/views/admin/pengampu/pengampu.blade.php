@extends('layouts.dashboardadmin-template')
@section('title', 'Kelola Pengampu')
@section('page-title', 'Kelola Dosen Pengampu')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4 shadow-sm rounded-3 bg-white">
        {{-- FORM FILTER --}}
        <form method="GET" action="{{ route('admin.pengampu') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <select name="kelas" class="form-select" required>
                        <option value="" hidden>Pilih Kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->kelas }}" {{ $selectedKelas==$k->kelas ? 'selected' : '' }}>
                            {{ $k->kelas }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <select name="periode_id" class="form-select" required>
                        <option value="" hidden>Pilih Periode</option>
                        @foreach($periodes as $p)
                        <option value="{{ $p->id }}" {{ $selectedPeriode==$p->id ? 'selected' : '' }}>
                            Semester {{ $p->semester }} - {{ $p->tahun }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                </div>
            </div>
            <hr class="horizontal dark mt-3">
        </form>

        {{-- FORM INPUT PENGAMPU --}}
        @if($selectedKelas && $selectedPeriode)
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Manajemen Dosen Pengampu Mata Kuliah atau Manajer Proyek</h4>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
        <form method="POST" action="{{ route('admin.pengampu.manage.store') }}">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">
            <input type="hidden" name="periode_id" value="{{ $selectedPeriode }}">

            <div class="table-responsive mt-2">
                <table class="table align-middle table-hover table-borderless border border-light shadow-sm rounded-3 overflow-hidden">
                    <thead class="text-sm fw-semibold text-white bg-primary">
                        <tr>
                            <th class="px-3 py-2">Mata Kuliah</th>
                            <th class="px-3 py-2">Dosen</th>
                            <th class="px-3 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($matkuls as $m)
                        <tr>
                            <td class="px-3 py-3">{{ $m->kode }} - {{ $m->matakuliah }}</td>
                            <td class="px-3 py-3">
                                <select name="data[{{ $m->id }}][dosen_id]" class="select2"
                                    required>
                                    <option value="" disabled selected hidden>Pilih Dosen</option>
                                    @foreach($dosen as $d)
                                    <option value="{{ $d->nip }}" {{ ($pengampus[$m->id]->dosen_id ?? '') == $d->nip ?
                                        'selected' : '' }}>
                                        {{ $d->nip }} - {{ $d->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-3 py-3">
                                <select name="data[{{ $m->id }}][status]" class="form-select" required>
                                    <option value="" disabled selected hidden>Pilih Status</option>
                                    <option value="Dosen Mata Kuliah" {{ ($pengampus[$m->id]->status ?? '') == 'Dosen Mata Kuliah' ? 'selected' : ''
                                        }}>
                                        Dosen Mata Kuliah</option>
                                    <option value="Manajer Proyek" {{ ($pengampus[$m->id]->status ?? '') == 'Manajer Proyek' ? 'selected' : '' }}>
                                        Manajer Proyek</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-end">
                <button class="btn btn-success mt-3" type="submit"><i class="bi bi-floppy me-1"></i> Simpan Semua</button>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection

@push('css')
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
        /* agar dropdown tidak tertutup elemen lain */
    }

    /* Efek focus */
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #F7CD07 !important;
        box-shadow: 0 0 0 2px rgba(247, 205, 7, 0.1);
        outline: none;
    }

    /* Dropdown dengan rounded full, selalu sama */
    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid #F7CD07 !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 4px 10px rgba(247, 205, 7, 0.1);
        margin-top: 2px;
        /* beri sedikit jarak dari select */
        overflow: hidden;
    }

    /* Agar dropdown yang muncul di atas juga rounded */
    .select2-container--bootstrap-5.select2-container--above .select2-dropdown {
        margin-top: 0;
        margin-bottom: 2px;
    }

    /* Render teks dan panah */
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
            placeholder: 'Pilih Dosen',
        });
    });
</script>
@endpush
