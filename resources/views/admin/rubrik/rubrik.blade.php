@extends('layouts.dashboardadmin-template')
@section('title', 'Rubrik Penilaian')
@section('page-title', 'Rubrik Penilaian')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Rubrik Penilaian</h4>
        </div>
        <p class="text-sm">Data Rubrik Penilaian untuk Menilai Kinerja PBL Mahasiswa</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.rubrik.store') }}">
            @csrf
            <div class="table-responsive">
                <table class="table align-middle table-hover table-borderless border border-light shadow-sm rounded-3 overflow-hidden">
                    <thead class="text-sm fw-semibold text-white bg-primary">
                        <tr>
                            <th style="width: 10%">Jenis</th>
                            <th>Aspek Penilaian</th>
                            <th style="width: 10%">Bobot (%)</th>
                        </tr>
                    </thead>
                    <tbody id="rubrik-body">
                        @foreach ($aspek as $i => $item)
                        <tr>
                            <td>
                                <input type="text" class="form-control bg-light" value="{{ $item->jenis }}" readonly>
                                <input type="hidden" name="rubrik[{{ $i }}][jenis]" value="{{ $item->jenis }}">
                            </td>
                            <td>
                                <input type="text" name="rubrik[{{ $i }}][aspek_penilaian]" value="{{ $item->aspek_penilaian }}" class="form-control" required>
                            </td>
                            <td>
                                <input type="number" name="rubrik[{{ $i }}][bobot]" value="{{ $item->bobot }}" class="form-control bobot-input text-center" required min="0" max="25">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end fw-bold">Total Bobot:
                                <div class="text-danger text-wrap" id="bobot-warning" style="display: none;">
                                    Total bobot tidak boleh lebih dari 100%.
                                </div>
                            </td>
                            <td class="text-center fw-bold">
                                <span id="total-bobot">0</span>%
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Rubrik</button>
            </div>
        </form>
    </div>
</div>

<script>
function hitungTotalBobot() {
    let total = 0;
    document.querySelectorAll('.bobot-input').forEach(input => {
        const value = parseFloat(input.value);
        if (!isNaN(value)) total += value;
    });

    document.getElementById('total-bobot').innerText = total;

    const warning = document.getElementById('bobot-warning');
    warning.style.display = total > 100 ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    hitungTotalBobot();

    document.querySelectorAll('.bobot-input').forEach(input => {
        input.addEventListener('input', hitungTotalBobot);
    });

    document.querySelector('form').addEventListener('submit', function (e) {
        const total = parseFloat(document.getElementById('total-bobot').innerText);
        if (total > 100) {
            e.preventDefault();
            alert('Total bobot tidak boleh lebih dari 100%.');
        }
    });
});
</script>
@endsection
