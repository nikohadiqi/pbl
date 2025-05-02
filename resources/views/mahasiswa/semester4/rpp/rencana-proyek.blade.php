@extends('layouts.dashboardmahasiswa-template')

@section('title','Rencana Pelaksanaan Proyek | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-pills nav-fill" id="tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="step1-tab" data-toggle="pill" href="#step1">1 Deskripsi Proyek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step2-tab" data-toggle="pill" href="#step2">2 Ruang Lingkup & Rancangan Sistem</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step3-tab" data-toggle="pill" href="#step3">3 Tahapan & Kebutuhan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step4-tab" data-toggle="pill" href="#step4">4 Tantangan & Estimasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step5-tab" data-toggle="pill" href="#step5">5 Biaya & Tim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step6-tab" data-toggle="pill" href="#step6">6 Mata Kuliah & Evaluasi</a>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="formTabsContent">
    <!-- Step 1: Informasi Dasar -->
    <div class="tab-pane fade show active" id="step1" role="tabpanel">
        <div class="card p-4 mb-4">
            <h4>Step 1: Informasi Dasar</h4>
            <div class="form-group mb-3">
                <label>ID Proyek</label>
                <input type="text" name="id_proyek" class="form-control" value="{{ old('id_proyek', $rencanaProyek->first()->id_proyek ?? '') }}" required>
            </div>
            <div class="form-group mb-3">
                <label>Judul Proyek</label>
                <input type="text" name="judul_proyek" class="form-control" value="{{ old('judul_proyek', $rencanaProyek->first()->judul_proyek ?? '') }}" required>
            </div>
            <div class="form-group mb-3">
                <label>Pengusul Proyek</label>
                <input type="text" name="pengusul_proyek" class="form-control" value="{{ old('pengusul_proyek', $rencanaProyek->first()->pengusul_proyek ?? '') }}" required>
            </div>
            <div class="form-group mb-3">
                <label>Manajer Proyek</label>
                <input type="text" name="manajer_proyek" class="form-control" value="{{ old('manajer_proyek', $rencanaProyek->first()->manajer_proyek ?? '') }}" required>
            </div>
            <div class="form-group mb-3">
                <label>Luaran</label>
                <textarea name="luaran" class="form-control" rows="3" required>{{ old('luaran', $rencanaProyek->first()->luaran ?? '') }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label>Sponsor</label>
                <textarea name="sponsor" class="form-control" rows="3" required>{{ old('sponsor', $rencanaProyek->first()->sponsor ?? '') }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label>Biaya</label>
                <textarea name="biaya" class="form-control" rows="3" required>{{ old('biaya', $rencanaProyek->first()->biaya ?? '') }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label>Klien</label>
                <textarea name="klien" class="form-control" rows="3" required>{{ old('klien', $rencanaProyek->first()->klien ?? '') }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label>Estimasi Waktu</label>
                <textarea name="waktu" class="form-control" rows="3" required>{{ old('waktu', $rencanaProyek->first()->waktu ?? '') }}</textarea>
            </div>
            <button type="button" class="btn btn-primary btn-next" data-next="#step2">Next</button>
        </div>
    </div>


<!-- Step 2: Ruang Lingkup & Rancangan Sistem -->
<div class="tab-pane fade" id="step2" role="tabpanel">
    <div class="card p-4 mb-4">
        <h4>Step 2: Ruang Lingkup & Rancangan Sistem</h4>
        <div class="form-group mb-3">
            <label>Ruang Lingkup</label>
            <textarea name="ruang_lingkup" class="form-control" rows="3" required>{{ old('ruang_lingkup', $rencanaProyek->first()->ruang_lingkup ?? '') }}</textarea>
        </div>
        <div class="form-group mb-3">
            <label>Rancangan Sistem</label>
            <textarea name="rancangan_sistem" class="form-control" rows="3" required>{{ old('rancangan_sistem', $rencanaProyek->first()->rancangan_sistem ?? '') }}</textarea>
        </div>
        <button type="button" class="btn btn-secondary btn-prev" data-prev="#step1">Previous</button>
        <button type="button" class="btn btn-primary btn-next" data-next="#step3">Next</button>
    </div>
</div>

<!-- Step 3: Tahapan Pelaksanaan & Kebutuhan Peralatan -->
<div class="tab-pane fade" id="step3" role="tabpanel">
    <div class="card p-4 mb-4">
        <h4>Step 3: Tahapan Pelaksanaan & Kebutuhan Peralatan</h4>

        <!-- Tahapan Pelaksanaan -->
        <h5 class="mt-3">Tahapan Pelaksanaan</h5>
        <table class="table table-bordered" id="tahapan-table">
            <thead>
                <tr>
                    <th>Minggu</th>
                    <th>Tahapan</th>
                    <th>PIC</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="number" name="minggu[]" class="form-control"></td>
                    <td><input type="text" name="tahapan[]" class="form-control"></td>
                    <td><input type="text" name="pic[]" class="form-control"></td>
                    <td><input type="text" name="keterangan[]" class="form-control"></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-success mb-3" onclick="addTahapanRow()">+ Tambah Tahapan</button>

        <!-- Kebutuhan Peralatan -->
        <h5 class="mt-4">Kebutuhan Peralatan</h5>
        <table class="table table-bordered" id="peralatan-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Fase</th>
                    <th>Peralatan</th>
                    <th>Bahan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="number" name="nomor[]" class="form-control"></td>
                    <td><input type="text" name="fase[]" class="form-control"></td>
                    <td><input type="text" name="peralatan[]" class="form-control"></td>
                    <td><input type="text" name="bahan[]" class="form-control"></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-success mb-4" onclick="addPeralatanRow()">+ Tambah Peralatan</button>

        <!-- Navigation buttons -->
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step2">Previous</button>
            <button type="button" class="btn btn-primary btn-next" data-next="#step4">Next</button>
        </div>
    </div>
</div>

<script>
    // Function to add a new row to the Tahapan Pelaksanaan table
    function addTahapanRow() {
        const tableBody = document.querySelector('#tahapan-table tbody');
        const newRow = document.createElement('tr');
        
        newRow.innerHTML = `
            <td><input type="number" name="minggu[]" class="form-control"></td>
            <td><input type="text" name="tahapan[]" class="form-control"></td>
            <td><input type="text" name="pic[]" class="form-control"></td>
            <td><input type="text" name="keterangan[]" class="form-control"></td>
        `;
        
        tableBody.appendChild(newRow);
    }

    // Function to add a new row to the Kebutuhan Peralatan table
    function addPeralatanRow() {
        const tableBody = document.querySelector('#peralatan-table tbody');
        const newRow = document.createElement('tr');
        
        newRow.innerHTML = `
            <td><input type="number" name="nomor[]" class="form-control"></td>
            <td><input type="text" name="fase[]" class="form-control"></td>
            <td><input type="text" name="peralatan[]" class="form-control"></td>
            <td><input type="text" name="bahan[]" class="form-control"></td>
        `;
        
        tableBody.appendChild(newRow);
    }
</script>



    <!-- Step 4: Tantangan & Estimasi Waktu -->
    <div class="tab-pane fade" id="step4" role="tabpanel">
        <div class="card p-4 mb-4">
            <h4>Step 4: Tantangan & Estimasi Waktu</h4>
            <div class="form-group mb-3">
                <label>Tantangan</label>
                <textarea name="tantangan" class="form-control" rows="3" required>{{ old('tantangan', $rencanaProyek->first()->tantangan ?? '') }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label>Estimasi Waktu</label>
                <textarea name="waktu" class="form-control" rows="3" required>{{ old('waktu', $rencanaProyek->first()->waktu ?? '') }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label>Ruang Lingkup</label>
                <textarea name="ruang_lingkup" class="form-control" rows="3" required>{{ old('ruang_lingkup', $rencanaProyek->first()->ruang_lingkup ?? '') }}</textarea>
            </div>
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step3">Previous</button>
            <button type="button" class="btn btn-primary btn-next" data-next="#step5">Next</button>
        </div>
    </div>

    <!-- Step 5: Klien & Biaya Proyek -->
    <div class="tab-pane fade" id="step5" role="tabpanel">
        <div class="card p-4 mb-4">
            <h4>Step 5: Klien & Biaya Proyek</h4>
            <div class="form-group mb-3">
                <label>Klien</label>
                <textarea name="klien" class="form-control" rows="3" required>{{ old('klien', $rencanaProyek->first()->klien ?? '') }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label>Biaya</label>
                <textarea name="biaya" class="form-control" rows="3" required>{{ old('biaya', $rencanaProyek->first()->biaya ?? '') }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label>Biaya Proyek</label>
                <textarea name="biaya_proyek" class="form-control" rows="3" required>{{ old('biaya_proyek', $rencanaProyek->first()->biaya_proyek ?? '') }}</textarea>
            </div>
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step4">Previous</button>
            <button type="button" class="btn btn-primary btn-next" data-next="#step6">Next</button>
        </div>
    </div>

    <!-- Step 6: Tim & Estimasi -->
    <div class="tab-pane fade" id="step6" role="tabpanel">
        <div class="card p-4 mb-4">
            <h4>Step 6: Tim & Estimasi</h4>
            <div class="form-group mb-3">
                <label>Estimasi</label>
                <input type="text" name="estimasi" class="form-control" value="{{ old('estimasi', $rencanaProyek->first()->estimasi ?? '') }}" required>
            </div>
            <div class="form-group mb-3">
                <label>Tim Proyek</label>
                <textarea name="tim_proyek" class="form-control" rows="3" required>{{ old('tim_proyek', $rencanaProyek->first()->tim_proyek ?? '') }}</textarea>
            </div>
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step5">Previous</button>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </div>
</div>


@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.nav-link');

        // Function to activate tab
        function activateTab(targetId) {
            // Remove active class from all tabs
            document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('show', 'active'));
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));

            // Activate the target tab
            const targetPane = document.querySelector(targetId);
            const targetNav = document.querySelector(`[href="${targetId}"]`);

            if (targetPane && targetNav) {
                targetPane.classList.add('show', 'active');
                targetNav.classList.add('active');
            }
        }

        // Tab navigation click handler
        navLinks.forEach(tab => {
            tab.addEventListener('click', function () {
                activateTab(this.getAttribute('href'));
            });
        });

        // Next button click handler
        document.querySelectorAll('.btn-next').forEach(button => {
            button.addEventListener('click', function () {
                const next = this.getAttribute('data-next');
                if (next) activateTab(next);
            });
        });

        // Previous button click handler
        document.querySelectorAll('.btn-prev').forEach(button => {
            button.addEventListener('click', function () {
                const prev = this.getAttribute('data-prev');
                if (prev) activateTab(prev);
            });
        });
    });
</script>
@endpush

@endsection
