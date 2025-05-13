    @extends('layouts.dashboardmahasiswa-template')

    @section('title','Rencana Pelaksanaan Proyek | Sistem Informasi dan Monitoring Project Based Learning')
    @section('page-title', 'Rencana Pelaksanaan Proyek')
    @section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <!-- <ul class="nav nav-pills nav-fill" id="tabs">
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
                </ul> -->
                <div class="step-wizard">
                    <div class="step active" data-target="#step1">
                        <div class="circle">1</div>
                        <div class="label">Deskripsi Proyek</div>
                    </div>
                    <div class="step" data-target="#step2">
                        <div class="circle">2</div>
                        <div class="label">Ruang Lingkup</div>
                    </div>
                    <div class="step" data-target="#step3">
                        <div class="circle">3</div>
                        <div class="label">Tahapan</div>
                    </div>
                    <div class="step" data-target="#step4">
                        <div class="circle">4</div>
                        <div class="label">Tantangan</div>
                    </div>
                    <div class="step" data-target="#step5">
                        <div class="circle">5</div>
                        <div class="label">Biaya & Tim</div>
                    </div>
                    <div class="step" data-target="#step6">
                        <div class="circle">6</div>
                        <div class="label">Evaluasi</div>
                    </div>
                </div>

                    <div class="tab-content" id="formTabsContent">
                        <!-- Step 1: Informasi Dasar -->
                        <div class="tab-pane fade show active" id="step1" role="tabpanel">
                            <div class="card p-4 mb-4">
                                <h4>Step 1: Informasi Dasar</h4>
                <!-- Form to submit project plan -->
                        <form method="POST" action="{{ route('mahasiswa.rpp.rencana-proyek.store') }}">
                            @csrf
                                                 
                    <div class="form-group mb-3">
                        <label>Judul Proyek</label>
                        <input type="text" name="judul_proyek" class="form-control" value="{{ old('judul_proyek', $rencanaProyek->judul_proyek ?? '') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>Pengusul Proyek</label>
                        <input type="text" name="pengusul_proyek" class="form-control" value="{{ old('pengusul_proyek', $rencanaProyek->pengusul_proyek ?? '') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>Manajer Proyek</label>
                        <input type="text" name="manajer_proyek" class="form-control" value="{{ old('manajer_proyek', $rencanaProyek->manajer_proyek ?? '') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>Luaran</label>
                        <textarea name="luaran" class="form-control" rows="3">{{ old('luaran', $rencanaProyek->luaran ?? '') }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Sponsor</label>
                        <textarea name="sponsor" class="form-control" rows="3">{{ old('sponsor', $rencanaProyek->sponsor ?? '') }}</textarea>
                    </div>

                  <div class="form-group mb-3">
                        <label>biaya</label>
                        <textarea name="biaya" class="form-control" rows="3">{{ old('biaya', $rencanaProyek->biaya ?? '') }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Klien</label>
                        <textarea name="klien" class="form-control" rows="3">{{ old('klien', $rencanaProyek->klien ?? '') }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Estimasi Waktu</label>
                        <textarea name="waktu" class="form-control" rows="3">{{ old('waktu', $rencanaProyek->waktu ?? '') }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Ruang Lingkup</label>
                        <textarea name="ruang_lingkup" class="form-control" rows="3" required>{{ old('ruang_lingkup', $rencanaProyek->ruang_lingkup ?? '') }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Rancangan Sistem</label>
                        <textarea name="rancangan_sistem" class="form-control" rows="3" required>{{ old('rancangan_sistem', $rencanaProyek->rancangan_sistem ?? '') }}</textarea>
                    </div>


                                <!-- Tombol Next -->
                                <button type="button" class="btn btn-primary btn-next" data-next="#step2">Next</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
                  </form>



                        <!-- Step 2: Ruang Lingkup & Rancangan Sistem -->
                        <div class="tab-pane fade" id="step2" role="tabpanel">
                            <div class="card p-4 mb-4">
                                <h4>Step 2: Ruang Lingkup & Rancangan Sistem</h4>
                                <div class="form-group mb-3">
                                    <label>Ruang Lingkup</label>
                                    <textarea name="ruang_lingkup" class="form-control" rows="3"
                                        required>{{ old('ruang_lingkup', $rencanaProyek->ruang_lingkup ?? '') }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Rancangan Sistem</label>
                                    <textarea name="rancangan_sistem" class="form-control" rows="3"
                                        required>{{ old('rancangan_sistem', $rencanaProyek->rancangan_sistem ?? '') }}</textarea>
                                </div>
                                <button type="button" class="btn btn-secondary btn-prev"
                                    data-prev="#step1">Previous</button>
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
                                <button type="button" class="btn btn-sm btn-success mb-3" onclick="addTahapanRow()">+ Tambah
                                    Tahapan</button>

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
                                            <td><input xtype="text" name="bahan[]" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-sm btn-success mb-4" onclick="addPeralatanRow()">+
                                    Tambah Peralatan</button>

                                <!-- Navigation buttons -->
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary btn-prev"
                                        data-prev="#step2">Previous</button>
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
                                <h4>Step 4: Tantangan & Estimasi</h4>

                                <!-- Tantangan -->
                                <h5 class="mt-3">Tantangan Dan Isu</h5>
                                <table class="table table-bordered" id="tahapan-table">
                                    <thead>
                                        <tr>
                                            <th>nomor</th>
                                            <th>proses</th>
                                            <th>isu</th>
                                            <th>level_resiko</th>
                                            <th>catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="number" name="nomor[]" class="form-control"></td>
                                            <td><input type="text" name="proses[]" class="form-control"></td>
                                            <td><input type="text" name="isu[]" class="form-control"></td>
                                            <td><input type="text" name="level_resiko[]" class="form-control"></td>
                                            <td><input type="text" name="catatan[]" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-sm btn-success mb-3" onclick="addTantanganRow()">+
                                    Tambah Isu</button>

                                <!-- Estimasi -->
                                <h5 class="mt-4">Estimasi</h5>
                                <table class="table table-bordered" id="peralatan-table">
                                    <thead>
                                        <tr>
                                            <th>Fase</th>
                                            <th>uraian_pekerjaan</th>
                                            <th>esstimasi_waktu</th>
                                            <th>catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="number" name="fase[]" class="form-control"></td>
                                            <td><input type="text" name="uraian_pekerjaan[]" class="form-control"></td>
                                            <td><input type="text" name="estimasi_waktu[]" class="form-control"></td>
                                            <td><input type="text" name="catatan[]" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-sm btn-success mb-4" onclick="addEstimasiRow()">+
                                    Tambah Estimasi</button>

                                <!-- Navigation buttons -->
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary btn-prev"
                                        data-prev="#step3">Previous</button>
                                    <button type="button" class="btn btn-primary btn-next" data-next="#step5">Next</button>
                                </div>
                            </div>
                        </div>

                        <script>
                            // Function to add a new row to the Tahapan Pelaksanaan table
        function addTantanganRow() {
            const tableBody = document.querySelector('#tantangan-table tbody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td><input type="number" name="nomor[]" class="form-control"></td>
                <td><input type="text" name="proses[]" class="form-control"></td>
                <td><input type="text" name="isu[]" class="form-control"></td>
                <td><input type="text" name="level_resiko[]" class="form-control"></td>
                <td><input type="text" name="catatan[]" class="form-control"></td>
            `;

            tableBody.appendChild(newRow);
        }

        // Function to add a new row to the Kebutuhan Peralatan table
        function addEstimasiRow() {
            const tableBody = document.querySelector('#Estimasi-table tbody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td><input type="number" name="fase[]" class="form-control"></td>
                <td><input type="text" name="uraian_pekerjaan[]" class="form-control"></td>
                <td><input type="text" name="estimasi_waktu[]" class="form-control"></td>
                <td><input type="text" name="catatan[]" class="form-control"></td>
            `;

            tableBody.appendChild(newRow);
        }
                        </script>

                        <!-- Step 5: Biaya-->
                        <div class="tab-pane fade" id="step5" role="tabpanel">
                            <div class="card p-4 mb-4">
                                <h4>Step 5: Biaya & Tim</h4>

                                <!-- Biya -->
                                <h5 class="mt-3">Biaya Proyek </h5>
                                <table class="table table-bordered" id="biaya-table">
                                    <thead>
                                        <tr>
                                            <th>Fase</th>
                                            <th>Uraian pekerjaan</th>
                                            <th>perkiraan biaya</th>
                                            <th>catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="number" name="fase[]" class="form-control"></td>
                                            <td><input type="text" name="uraian_pekerjaan[]" class="form-control"></td>
                                            <td><input type="text" name="biaya[]" class="form-control"></td>
                                            <td><input type="text" name="catatan[]" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-sm btn-success mb-3" onclick="addBiayaRow()">+ Tambah
                                    Biaya</button>

                                <!-- Navigation buttons -->
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary btn-prev"
                                        data-prev="#step4">Previous</button>
                                    <button type="button" class="btn btn-primary btn-next" data-next="#step6">Next</button>
                                </div>
                            </div>
                        </div>

                        <script>
                            // Function to add a new row to the Tahapan Pelaksanaan table
        function addBiayaRow() {
            const tableBody = document.querySelector('#biaya-table tbody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td><input type="number" name="fase[]" class="form-control"></td>
                <td><input type="text" name="uraian_pekerjaan[]" class="form-control"></td>
                <td><input type="text" name="biaya[]" class="form-control"></td>
                <td><input type="text" name="catatan[]" class="form-control"></td>
            `;

            tableBody.appendChild(newRow);
        }
                        </script>
{{-- 
                        <!-- Step 6:Evaluasi -->

                                <!-- Pemantauan & Evaluasi -->
                                <div class="form-group mb-3">2
                                    <label>Evaluasi</label>
                                    <textarea name="tim_proyek" class="form-control" rows="3"
                                        required>{{ old('tim_proyek', $rencanaProyek->tim_proyek ?? '') }}</textarea>
                                </div>
                                <!-- Navigation buttons -->
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary btn-prev"
                                        data-prev="#step5">Previous</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </div>
                        </div>

                        <script>
                            // Function to add a new row to the Tahapan Pelaksanaan table --}}

    </form>
    </div>
    @endsection

    @push ('css')
    <style>
        .step-wizard {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            margin: 20px auto 30px;
            max-width: 800px;
        }

        .step-wizard::before {
            content: '';
            position: absolute;
            top: 18px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #e0e0e0;
            z-index: 0;
        }

        .step {
            position: relative;
            text-align: center;
            flex: 1;
            font-size: 11px;
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
            background-color: #F7CD07;
        }

        .step .label {
            margin-top: 6px;
            font-size: 11px;
            line-height: 1.2;
            word-break: break-word;
        }

        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 14px;
            left: 50%;
            width: 100%;
            height: 2px;
            background-color: #F7CD07;
            z-index: -1;
            transform: translateX(14px);
        }

        .step:last-child::after {
            display: none;
        }
    </style>
    @endpush

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const steps = document.querySelectorAll('.step');

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
    @endpush
