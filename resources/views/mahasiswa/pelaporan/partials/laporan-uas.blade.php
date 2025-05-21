<div class="card shadow-sm my-4 border-start border-2 position-relative">
    <div class="card-header">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-file-earmark-arrow-up text-success me-2 text-primary"></i> Laporan UAS
        </h4>
    </div>
    <div class="card-body">
        <div>
            <button class="btn btn-outline-primary btn-sm me-2 toggle-laporan" type="button"
                data-target="#formLaporanUAS" aria-expanded="false" aria-controls="formLaporanUAS">
                <i class="bi bi-pencil-square me-1"></i> Isi Pelaporan UAS
            </button>
            @if($pelaporanUAS)
            <button class="btn btn-outline-secondary btn-sm toggle-laporan" type="button" data-target="#viewLaporanUAS"
                aria-expanded="false" aria-controls="viewLaporanUAS">
                <i class="bi bi-eye me-1"></i> Lihat Pelaporan UAS
            </button>
            @endif
        </div>

        @include('mahasiswa.pelaporan.partials.form-laporan', [
        'idCollapse' => 'formLaporanUAS',
        'action' => route('mahasiswa.pelaporan-pbl.laporan-uas.store'),
        'kode_tim' => $kode_tim,
        'pelaporan' => $pelaporanUAS,
        'prefix' => 'uas',
        'buttonClass' => 'btn-success'
        ])

        @include('mahasiswa.pelaporan.partials.view-laporan', [
        'idCollapse' => 'viewLaporanUAS',
        'pelaporan' => $pelaporanUAS,
        'borderClass' => 'border-primary',
        'textColor' => 'text-success',
        'btnColor' => 'btn-outline-success'
        ])
    </div>
</div>
