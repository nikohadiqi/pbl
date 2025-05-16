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
            placeholder: 'Pilih Dosen',
            allowClear: true
        });
    });
</script>
@endpush
