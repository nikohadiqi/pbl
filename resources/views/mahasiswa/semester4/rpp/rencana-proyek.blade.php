 @extends('layouts.dashboardmahasiswa-template')

@section('title','Rencana Pelaksanaan Proyek | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Rencana Pelaksanaan Proyek')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <div class="step-wizard d-flex justify-content-between mb-4">
                <div class="step active" data-target="#step1">
                    <div class="circle">1</div>
                    <div class="label">Deskripsi Proyek</div>
                </div>
                <div class="step" data-target="#step2">
                    <div class="circle">2</div>
                    <div class="label">Tahapan</div>
                </div>
                <div class="step" data-target="#step3">
                    <div class="circle">3</div>
                    <div class="label">Kebutuhan Peralatan</div>
                </div>
                <div class="step" data-target="#step4">
                    <div class="circle">4</div>
                    <div class="label">Tantangan</div>
                </div>
                <div class="step" data-target="#step5">
                    <div class="circle">5</div>
                    <div class="label">Biaya</div>
                </div>
                <div class="step" data-target="#step6">
                    <div class="circle">6</div>
                    <div class="label">Estimasi</div>
                </div>
                <div class="step" data-target="#step7">
                    <div class="circle">7</div>
                    <div class="label">Evaluasi</div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="tab-content" id="formTabsContent">

                <!-- STEP 1 -->
                <div class="tab-pane fade show active" id="step1" role="tabpanel">
                    <form method="POST" action="{{ route('mahasiswa.rpp.rencana-proyek.store') }}">
                        @csrf
                        <h4>Step 1: Deskripsi Proyek</h4>

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
                            <textarea name="luaran" class="form-control">{{ old('luaran', $rencanaProyek->luaran ?? '') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Sponsor</label>
                            <textarea name="sponsor" class="form-control">{{ old('sponsor', $rencanaProyek->sponsor ?? '') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Biaya</label>
                            <textarea name="biaya" class="form-control">{{ old('biaya', $rencanaProyek->biaya ?? '') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Klien</label>
                            <textarea name="klien" class="form-control">{{ old('klien', $rencanaProyek->klien ?? '') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Estimasi Waktu</label>
                            <textarea name="waktu" class="form-control">{{ old('waktu', $rencanaProyek->waktu ?? '') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Ruang Lingkup</label>
                            <textarea name="ruang_lingkup" class="form-control">{{ old('ruang_lingkup', $rencanaProyek->ruang_lingkup ?? '') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Rancangan Sistem</label>
                            <textarea name="rancangan_sistem" class="form-control">{{ old('rancangan_sistem', $rencanaProyek->rancangan_sistem ?? '') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-primary btn-next" data-next="#step2">Next</button>
                        </div>
                    </form>
                </div>

<!-- STEP 2 -->
<div class="tab-pane fade {{ session('active_step') == 'step2' ? 'show active' : '' }}" id="step2" role="tabpanel">
    <form method="POST" action="{{ route('mahasiswa.rpp.tahapan-pelaksanaan.store') }}">
        @csrf
        <h4>Step 2: Tahapan Pelaksanaan</h4>

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
                @if (!empty($tahapanPelaksanaan) && $tahapanPelaksanaan->count())
                    @foreach ($tahapanPelaksanaan as $tahapan)
                        <tr>
                            <td><input type="number" name="minggu[]" class="form-control" value="{{ old('minggu.' . $loop->index, $tahapan->minggu) }}"></td>
                            <td><input type="text" name="tahapan[]" class="form-control" value="{{ old('tahapan.' . $loop->index, $tahapan->tahapan) }}"></td>
                            <td><input type="text" name="pic[]" class="form-control" value="{{ old('pic.' . $loop->index, $tahapan->pic) }}"></td>
                            <td><input type="text" name="keterangan[]" class="form-control" value="{{ old('keterangan.' . $loop->index, $tahapan->keterangan) }}"></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td><input type="number" name="minggu[]" class="form-control" value="{{ old('minggu.0') }}"></td>
                        <td><input type="text" name="tahapan[]" class="form-control" value="{{ old('tahapan.0') }}"></td>
                        <td><input type="text" name="pic[]" class="form-control" value="{{ old('pic.0') }}"></td>
                        <td><input type="text" name="keterangan[]" class="form-control" value="{{ old('keterangan.0') }}"></td>
                    </tr>
                @endif
            </tbody>
        </table>

        <button type="button" class="btn btn-sm btn-success mb-3" onclick="addTahapanRow()">+ Tambah Tahapan</button>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step1">Previous</button>
            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-primary btn-next" data-next="#step3">Next</button>
        </div>
    </form>
</div>

<script>
    function addTahapanRow() {
        var table = document.getElementById('tahapan-table').getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        newRow.innerHTML = `
            <td><input type="number" name="minggu[]" class="form-control"></td>
            <td><input type="text" name="tahapan[]" class="form-control"></td>
            <td><input type="text" name="pic[]" class="form-control"></td>
            <td><input type="text" name="keterangan[]" class="form-control"></td>
        `;
    }
</script>

<!-- STEP 3 -->
<div class="tab-pane fade {{ session('active_step') == 'step3' ? 'show active' : '' }}" id="step3" role="tabpanel">
    <form method="POST" action="{{ route('mahasiswa.rpp.kebutuhan-peralatan.store') }}">
        @csrf
        <h4>Step 3: Kebutuhan Peralatan</h4>

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
                @if (!empty($kebutuhanPeralatan) && $kebutuhanPeralatan->count())
                    @foreach ($kebutuhanPeralatan as $peralatan)
                        <tr>
                            <td><input type="number" name="nomor[]" class="form-control" value="{{ old('nomor.' . $loop->index, $peralatan->nomor) }}"></td>
                            <td><input type="text" name="fase[]" class="form-control" value="{{ old('fase.' . $loop->index, $peralatan->fase) }}"></td>
                            <td><input type="text" name="peralatan[]" class="form-control" value="{{ old('peralatan.' . $loop->index, $peralatan->peralatan) }}"></td>
                            <td><input type="text" name="bahan[]" class="form-control" value="{{ old('bahan.' . $loop->index, $peralatan->bahan) }}"></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td><input type="number" name="nomor[]" class="form-control" value="{{ old('nomor.0') }}"></td>
                        <td><input type="text" name="fase[]" class="form-control" value="{{ old('fase.0') }}"></td>
                        <td><input type="text" name="peralatan[]" class="form-control" value="{{ old('peralatan.0') }}"></td>
                        <td><input type="text" name="bahan[]" class="form-control" value="{{ old('bahan.0') }}"></td>
                    </tr>
                @endif
            </tbody>
        </table>

        <button type="button" class="btn btn-sm btn-success mb-4" onclick="addPeralatanRow()">+ Tambah Peralatan</button>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step2">Previous</button>
            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-primary btn-next" data-next="#step4">Next</button>
        </div>
    </form>
</div>

<script>
    function addPeralatanRow() {
        var table = document.getElementById('peralatan-table').getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        newRow.innerHTML = `
            <td><input type="number" name="nomor[]" class="form-control"></td>
            <td><input type="text" name="fase[]" class="form-control"></td>
            <td><input type="text" name="peralatan[]" class="form-control"></td>
            <td><input type="text" name="bahan[]" class="form-control"></td>
        `;
    }
</script>

<!-- STEP 4 -->
<div class="tab-pane fade {{ session('active_step') == 'step4' ? 'show active' : '' }}" id="step4" role="tabpanel">
    <form method="POST" action="{{ route('mahasiswa.rpp.tantangan.store') }}">
        @csrf
        <h4>Step 4: Tantangan</h4>

        <table class="table table-bordered" id="tantangan-table">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Proses</th>
                    <th>Isu</th>
                    <th>Level Resiko</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($tantanganList) && $tantanganList->count())
                    @foreach ($tantanganList as $tantangan)
                        <tr>
                            <td><input type="number" name="nomor[]" class="form-control" value="{{ old('nomor.' . $loop->index, $tantangan->nomor) }}"></td>
                            <td><input type="text" name="proses[]" class="form-control" value="{{ old('proses.' . $loop->index, $tantangan->proses) }}"></td>
                            <td><input type="text" name="isu[]" class="form-control" value="{{ old('isu.' . $loop->index, $tantangan->isu) }}"></td>
                            <td><input type="text" name="level_resiko[]" class="form-control" value="{{ old('level_resiko.' . $loop->index, $tantangan->level_resiko) }}"></td>
                            <td><input type="text" name="catatan[]" class="form-control" value="{{ old('catatan.' . $loop->index, $tantangan->catatan) }}"></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td><input type="number" name="nomor[]" class="form-control" value="{{ old('nomor.0') }}"></td>
                        <td><input type="text" name="proses[]" class="form-control" value="{{ old('proses.0') }}"></td>
                        <td><input type="text" name="isu[]" class="form-control" value="{{ old('isu.0') }}"></td>
                        <td><input type="text" name="level_resiko[]" class="form-control" value="{{ old('level_resiko.0') }}"></td>
                        <td><input type="text" name="catatan[]" class="form-control" value="{{ old('catatan.0') }}"></td>
                    </tr>
                @endif
            </tbody>
        </table>

        <button type="button" class="btn btn-sm btn-success mb-3" onclick="addTantanganRow()">+ Tambah Tantangan</button>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step3">Previous</button>
            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-primary btn-next" data-next="#step5">Next</button>
        </div>
    </form>
</div>

<script>
    function addTantanganRow() {
        var table = document.getElementById('tantangan-table').getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        newRow.innerHTML = `
            <td><input type="number" name="nomor[]" class="form-control"></td>
            <td><input type="text" name="proses[]" class="form-control"></td>
            <td><input type="text" name="isu[]" class="form-control"></td>
            <td><input type="text" name="level_resiko[]" class="form-control"></td>
            <td><input type="text" name="catatan[]" class="form-control"></td>
        `;
    }
</script>


                        <!-- Step 5: Biaya-->
                                     <div class="tab-pane fade {{ session('active_step') == 'step5' ? 'show active' : '' }}" id="step5" role="tabpanel">
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
              <!-- STEP 6 -->
                <div class="tab-pane fade {{ session('active_step') == 'step6' ? 'show active' : '' }}" id="step6" role="tabpanel">
                    {{-- <form method="POST" action="{{ route('mahasiswa.rpp.tahapan-pelaksanaan.store') }}">
                        @csrf --}}
                        <h4>Step 6: Estimasi</h4>
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
        
                <!-- Step 7:Evaluasi -->

                            {{-- <div class="tab-pane fade show active" id="step7" role="tabpanel">
                    {{-- <form method="POST" action="{{ route('mahasiswa.rpp.rencana-proyek.store') }}">
                        @csrf --}}
                        {{-- <h4>Step 7: Evaluasi</h4>

                        <div class="form-group mb-3">
                            <label>Evaluasi</label>
                            <input type="text" name="judul_proyek" class="form-control" value="{{ old('judul_proyek', $rencanaProyek->judul_proyek ?? '') }}">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-primary btn-next" data-next="#step1">Next</button>
                            <button type="button" class="btn btn-secondary btn-prev" data-prev="#step5">Previous</button>
                        </div>
                    </form>
                </div> --}} 

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
