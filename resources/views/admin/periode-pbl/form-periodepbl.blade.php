@extends('layouts.dashboardadmin-template')

@section('title', ($isEdit ? 'Ubah' : 'Tambah') . ' Periode PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', ($isEdit ? 'Ubah' : 'Tambah') . ' Data Periode PBL')
@section('page-title-1', 'Data Periode PBL')
@section('page-title-1-url', route('admin.periodepbl'))

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <h5 class="fw-bold">{{ $isEdit ? 'Ubah' : 'Tambah' }} Data Periode PBL</h5>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ $isEdit ? route('admin.periodepbl.update', $periode->id) : route('admin.periodepbl.store') }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="kategori_semester">Kategori Semester</label>
                    <select name="kategori_semester" id="kategori_semester" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Ganjil" {{ old('kategori_semester', $periode->kategori_semester ?? '') == 'Ganjil' ?
                            'selected' : '' }}>Semester Ganjil (1, 3, 5)</option>
                        <option value="Genap" {{ old('kategori_semester', $periode->kategori_semester ?? '') == 'Genap' ? 'selected'
                            : '' }}>Semester Genap (2, 4, 6)</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="tahun_display">Tahun</label>
                    <input type="text" id="tahun_display" class="form-control" value="{{ old('tahun', $periode->tahun ?? '') }}"
                        readonly>
                    <input type="hidden" name="tahun" id="tahun_hidden" value="{{ old('tahun', $periode->tahun ?? '') }}">
                    @error('tahun') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mt-2">
                <div class="form-group col-md-6">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                        value="{{ old('tanggal_mulai', isset($periode->tanggal_mulai) ? $periode->tanggal_mulai->format('Y-m-d') : '') }}" required>
                    @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="tanggal_selesai">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                        value="{{ old('tanggal_selesai', isset($periode->tanggal_selesai) ? $periode->tanggal_selesai->format('Y-m-d') : '') }}" required>
                    @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-floppy me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.periodepbl') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tanggalMulai = document.getElementById("tanggal_mulai");
        const tanggalSelesai = document.getElementById("tanggal_selesai");
        const tahunHidden = document.getElementById("tahun_hidden");
        const tahunDisplay = document.getElementById("tahun_display");

        tanggalMulai.addEventListener("change", function () {
            const selectedDate = new Date(this.value);
            if (!isNaN(selectedDate)) {
                const tahun = selectedDate.getFullYear();
                tahunHidden.value = tahun;
                tahunDisplay.value = tahun;
                tanggalSelesai.min = this.value;
            }
        });
    });
</script>
@endpush
