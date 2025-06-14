@extends('layouts.dashboardmahasiswa-template')

@section('title','Rencana Pelaksanaan Proyek | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Rencana Pelaksanaan Proyek')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            @include('mahasiswa.rpp.partials.wizard-nav')
        </div>

        <div class="card-body">
            <div class="tab-content" id="formTabsContent">
                <!-- STEP 1 -->
                @include('mahasiswa.rpp.partials.step1')
                <!-- STEP 2 -->
                @include('mahasiswa.rpp.partials.step2')
                <!-- STEP 3 -->
                @include('mahasiswa.rpp.partials.step3')
                <!-- STEP 4 -->
                @include('mahasiswa.rpp.partials.step4')
                <!-- STEP 5 -->
                @include('mahasiswa.rpp.partials.step5')
                <!-- STEP 6 -->
                @include('mahasiswa.rpp.partials.step6')
            </div>
        </div>
    </div>
</div>
@endsection

@push ('css')
<style>
    .step-wizard {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin: 20px auto 5px;
        max-width: 800px;
        padding: 0 14px;
        /* Geser garis ke dalam agar sejajar dengan tengah lingkaran */
    }

    .step-wizard::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 50%;
        width: 100%;
        height: 1px;
        background-color: #e0e0e0;
        z-index: -1;
        transform: translateY(14px);
    }

    .step {
        position: relative;
        text-align: center;
        flex: 1;
        font-size: 11px;
        z-index: 1;
    }

    .step .circle {
        width: 28px;
        height: 28px;
        margin: 0 auto;
        border-radius: 50%;
        background-color: #ccc;
        line-height: 28px;
        font-size: 13px;
        color: white;
        font-weight: 600;
        z-index: 2;
        position: relative;
    }

    .step.active .circle {
        background-color: #dfa02c;
    }

    .step .label {
        margin-top: 10px;
        font-size: 13px;
        line-height: 1.2;
        word-break: break-word;
    }

    .step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 14px;
        left: 50%;
        width: 100%;
        height: 1px;
        background-color: #e0e0e0;
        z-index: -1;
        transform: translateX(14px);
    }

    .step:last-child::after {
        display: none;
    }
</style>
@endpush

@push('js')
{{-- wizzard --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const steps = document.querySelectorAll('.step');

        const ruangLingkupQuill = new Quill('#ruang_lingkup_editor', { theme: 'snow' });
        const rancanganSistemQuill = new Quill('#rancangan_sistem_editor', { theme: 'snow' });
        const evaluasiQuill = new Quill('#evaluasi_editor', { theme: 'snow' });

        // Set initial data dari server
        ruangLingkupQuill.clipboard.dangerouslyPasteHTML(`{!! old('ruang_lingkup', $rencanaProyek->ruang_lingkup ?? '') !!}`);
        rancanganSistemQuill.clipboard.dangerouslyPasteHTML(`{!! old('rancangan_sistem', $rencanaProyek->rancangan_sistem ?? '') !!}`);
        evaluasiQuill.clipboard.dangerouslyPasteHTML(`{!! old('evaluasi', $rencanaProyek->evaluasi ?? '') !!}`);

        // Sync ke input saat submit
        document.getElementById('rencanaForm').addEventListener('submit', function () {
            document.getElementById('ruang_lingkup_input').value = ruangLingkupQuill.root.innerHTML;
            document.getElementById('rancangan_sistem_input').value = rancanganSistemQuill.root.innerHTML;
            document.getElementById('evaluasi_input').value = evaluasiQuill.root.innerHTML;
        });

        function activateStep(targetId) {
            // Remove active from all
            steps.forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('show', 'active'));

            // Add active to current
            const targetStep = document.querySelector(`[data-target="${targetId}"]`);
            const targetPane = document.querySelector(targetId);
            if (targetStep && targetPane) {
                targetStep.classList.add('active');
                targetPane.classList.add('show', 'active');
            }
        }

            // Click on steps
        steps.forEach(step => {
        step.addEventListener('click', () => {
            const target = step.getAttribute('data-target');
                if (target) activateStep(target);
            });
        });

        // Next and Previous Button Handlers (optional)
        document.querySelectorAll('.btn-next').forEach(button => {
            button.addEventListener('click', function () {
                const next = this.getAttribute('data-next');
                if (next) activateStep(next);
            });
        });

        document.querySelectorAll('.btn-prev').forEach(button => {
            button.addEventListener('click', function () {
                const prev = this.getAttribute('data-prev');
                    if (prev) activateStep(prev);
            });
        });
    });
</script>

{{-- Hapus Baris --}}
<script>
function removeRow(button) {
    button.closest("tr").remove();
}
</script>

{{-- Tahapan --}}
<script>
function addTahapanRow() {
    const table = document.querySelector("#tahapan-table tbody");
    const row = document.createElement("tr");
    row.innerHTML = `
        <td><input type="number" name="minggu[]" class="form-control"></td>
        <td><input type="text" name="tahapan[]" class="form-control"></td>
        <td><input type="text" name="pic[]" class="form-control"></td>
        <td><input type="text" name="keterangan[]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
    `;
    table.appendChild(row);
}
</script>

{{-- Peralatan --}}
<script>
    function addPeralatanRow() {
        const table = document.querySelector('#peralatan-table tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="number" name="nomor[]" class="form-control"></td>
            <td><input type="text" name="fase[]" class="form-control"></td>
            <td><input type="text" name="peralatan[]" class="form-control"></td>
            <td><input type="text" name="bahan[]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        `;
        table.appendChild(row);
    }
</script>

{{-- Tantangan --}}
<script>
    function addTantanganRow() {
        const table = document.querySelector('#tantangan-table tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
        <td><input type="number" name="nomor[]" class="form-control"></td>
        <td><input type="text" name="proses[]" class="form-control"></td>
        <td><input type="text" name="isu[]" class="form-control"></td>
        <td>
            <select name="level_resiko[]" class="form-control">
                <option value="" selected disabled>-- Pilih Level --</option>
                <option value="H">H</option>
                <option value="M">M</option>
                <option value="L">L</option>
            </select>
        </td>
        <td><input type="text" name="catatan[]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        `;
        table.appendChild(row);
    }
</script>

{{-- Biaya --}}
<script>
    function addBiayaRow() {
        const table = document.querySelector('#biaya-table tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" name="fase[]" class="form-control"></td>
            <td><input type="text" name="uraian_pekerjaan[]" class="form-control"></td>
            <td><input type="text" name="perkiraan_biaya[]" class="form-control"></td>
            <td><input type="text" name="catatan[]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        `;
        table.appendChild(row);
    }
</script>

{{-- Estimasi --}}
<script>
    function addEstimasiRow() {
        const table = document.querySelector('#estimasi-table tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" name="fase[]" class="form-control"></td>
            <td><input type="text" name="uraian_pekerjaan[]" class="form-control"></td>
            <td><input type="text" name="estimasi_waktu[]" class="form-control"></td>
            <td><input type="text" name="catatan[]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        `;
        table.appendChild(row);
    }
</script>
@endpush
