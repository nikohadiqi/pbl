<div class="form-group">
    <label for="kelas_id" class="form-control-label">Kelas</label>
    <select name="kelas_id" class="form-control">
        <option value="" disabled selected hidden>Pilih Kelas</option>
        @foreach($kelas as $k)
            <option value="{{ $k->kelas }}" {{ (old('kelas_id', $pengampu->kelas_id ?? '') == $k->kelas) ? 'selected' : '' }}>{{ $k->kelas }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="dosen_id" class="form-control-label">Dosen</label>
    <select name="dosen_id" class="form-control select2">
        <option value="" disabled selected hidden>Pilih Dosen</option>
        @foreach($dosen as $d)
            <option value="{{ $d->nip }}" {{ (old('dosen_id', $pengampu->dosen_id ?? '') == $d->nip) ? 'selected' : '' }}>
                {{ $d->nip }} - {{ $d->nama }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="matkul_id" class="form-control-label">Mata Kuliah</label>
    <select name="matkul_id" class="form-control">
        <option value="" disabled selected hidden>Pilih Mata Kuliah</option>
        @foreach($matkuls as $m)
            <option value="{{ $m->id }}" {{ (old('matkul_id', $pengampu->matkul_id ?? '') == $m->id) ? 'selected' : '' }}>{{ $m->kode }} - {{ $m->matakuliah }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="status" class="form-control-label">Status</label>
    <select name="status" class="form-control">
        <option value="" disabled selected hidden>Pilih Status Pengampu</option>
        <option value="Manajer Proyek" {{ (old('status', $pengampu->status ?? '') == 'Manajer Proyek') ? 'selected' : '' }}>Manajer Proyek</option>
        <option value="Dosen Mata Kuliah" {{ (old('status', $pengampu->status ?? '') == 'Dosen Mata Kuliah') ? 'selected' : '' }}>Dosen Mata Kuliah</option>
    </select>
</div>

<div class="form-group">
    <label for="periode_id" class="form-control-label">Periode</label>
    <select name="periode_id" class="form-control">
        <option value="" disabled selected hidden>Pilih Periode</option>
        @foreach($periodes as $p)
            <option value="{{ $p->id }}" {{ (old('periode_id', $pengampu->periode_id ?? '') == $p->id) ? 'selected' : '' }}>Semester {{ $p->semester }} - {{ $p->tahun }}</option>
        @endforeach
    </select>
</div>

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
