@extends('layouts.dashboardadmin-template')

@section('title','Edit Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Edit Data Tim PBL</h5>
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

            <!-- Ketua Tim (Search by NIM) -->
            <div class="form-group mb-3">
                <label for="ketua_tim">Ketua Tim</label>
                <div class="input-group">
                    <input type="text" class="form-control @error('ketua_tim') is-invalid @enderror"
                           id="ketua_tim" name="ketua_tim"
                           placeholder="Cari berdasarkan NIM..."
                           value="{{ old('ketua_tim', $timPBL->ketua_tim) }}" required>
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
                <div id="info_ketua" class="mt-3">
                    @if($timPBL->ketua)
                        Nama Ketua: {{ $timPBL->ketua->nama }}<br>
                        Kelas: {{ $timPBL->ketua->kelas }}<br>
                        NIM: {{ $timPBL->ketua->nim }}
                    @endif
                </div>
                @error('ketua_tim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Periode -->
            <div class="form-group">
                <label for="periode_id">Periode PBL</label>
                <select class="form-control" id="periode_id" name="periode_id">
                    <option value="" disabled selected hidden>Pilih Periode PBL</option>
                    @foreach($periode as $periodepbl)
                    <option value="{{ $periodepbl->id }}"
                        {{ old('periode_id', $timPBL->periode_id) == $periodepbl->id ? 'selected' : '' }}>
                        Semester {{ $periodepbl->semester }} - {{ $periodepbl->tahun }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="{{ route('admin.timpbl') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let debounceTimer;

        $('#ketua_tim').on('input', function () {
            clearTimeout(debounceTimer);
            let nim = $(this).val();

            debounceTimer = setTimeout(function () {
                if (nim.length >= 6) {
                    $.ajax({
                        url: "{{ route('admin.timpbl.cariKetua') }}",
                        method: "GET",
                        data: { nim: nim },
                        success: function (response) {
                            if (response.success) {
                                $('#info_ketua').html(`
                                    Nama Ketua: ${response.nama}<br>
                                    Kelas: ${response.kelas}<br>
                                    NIM: ${response.nim}
                                `).fadeIn();
                            } else {
                                $('#info_ketua').fadeOut();
                            }
                        }
                    });
                } else {
                    $('#info_ketua').fadeOut();
                }
            }, 800);
        });
    });
</script>
@endpush
