@extends('layouts.dashboardadmin-template')

@section('title', 'Tambah Tim PBL')

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

            <!-- Ketua Tim (Search by NIM) -->
            <div class="form-group mb-3">
                <label for="ketua_tim">Ketua Tim</label>
                <div class="input-group">
                    <input type="text" class="form-control @error('ketua_tim') is-invalid @enderror"
                           id="ketua_tim" name="ketua_tim" placeholder="Cari berdasarkan NIM..." required>
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
                <!-- Display Data Pelanggan yang Ditemukan -->
                <div id="info_ketua" class="mt-3"></div>
                @error('ketua_tim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="{{ route('admin.timpbl') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
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
            }, 1000); // tunggu 1 detik setelah berhenti mengetik
        });
    });
</script>
@endpush
@endsection

