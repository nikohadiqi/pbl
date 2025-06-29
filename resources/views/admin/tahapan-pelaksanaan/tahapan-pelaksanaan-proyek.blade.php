@extends('layouts.dashboardadmin-template')
@section('title', 'Tahapan Pelaksanaan Proyek')
@section('page-title', 'Tahapan Pelaksanaan Proyek')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">
                Tahapan Pelaksanaan Proyek
                <span>Semester {{ $periodeAktif->kategori_semester }}/Tahun {{ $periodeAktif->tahun }}</span>
            </h4>
            <!-- Form Import -->
            <form id="import-tahapan-form" action="{{ route('admin.tpp.import') }}" method="POST"
                enctype="multipart/form-data" style="display: none;">
                @csrf
                <input type="file" id="import-tahapan-file" name="file" accept=".xlsx,.xls,.csv"
                    onchange="document.getElementById('import-tahapan-form').submit();">
            </form>
            <!-- Tombol Trigger -->
            <button type="button" class="btn btn-primary fw-bold mb-3"
                onclick="document.getElementById('import-tahapan-file').click();">
                <i class="bi bi-upload me-2"></i>Impor Tahapan
            </button>
        </div>
        <p class="text-sm">Daftar Tahapan Pelaksanaan Proyek Mahasiswa</p>
        {{-- Form Tahapan --}}
        <form method="POST" action="{{ route('admin.tpp.store') }}" class="mt-3">
            @csrf
            <div class="table-responsive">
                <table
                    class="table align-middle table-hover table-borderless border border-light shadow-sm rounded-3 overflow-hidden">
                    <thead class="text-sm fw-semibold text-white bg-primary">
                        <tr>
                            <th style="width: 5%">Minggu Ke-</th>
                            <th>Nama Tahapan</th>
                            <th style="width: 10%">Score (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 16; $i++) <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>
                                <input type="text" name="tahapan[]" class="form-control"
                                    value="{{ old('tahapan.' . $i, $tahapan[$i]->tahapan ?? '') }}">
                            </td>
                            <td>
                                <input type="number" name="score[]" class="form-control text-center"
                                    value="{{ old('score.' . $i, $tahapan[$i]->score ?? '') }}" min="5" max="10">
                            </td>
                            </tr>
                            @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end fw-bold">Total Score :</td>
                            <td class="text-center fw-bold">
                                <span id="total-score">0</span>%
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-end">
                <button class="btn btn-primary mt-3" type="submit"><i class="bi bi-floppy me-1"></i> Simpan
                    Semua</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
{{-- Score Total --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const scoreInputs = document.querySelectorAll('input[name="score[]"]');
    const totalScoreDisplay = document.getElementById('total-score');

    function updateTotalScore() {
        let total = 0;
        scoreInputs.forEach(input => {
            const val = parseFloat(input.value);
            if (!isNaN(val)) total += val;
        });
        totalScoreDisplay.textContent = total;
    }

    // Hitung ulang setiap kali input berubah
    scoreInputs.forEach(input => {
        input.addEventListener('input', updateTotalScore);
    });

    // Hitung awal saat halaman dimuat (untuk data lama)
    updateTotalScore();
});
</script>

{{-- Confirm Reset --}}
<script>
    function confirmReset() {
        Swal.fire({
            title: 'Yakin ingin mereset semua tahapan?',
            text: "Semua data tahapan untuk periode ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Reset!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('reset-form').submit();
            }
        });
    }
</script>
@endpush
