<div class="card shadow-sm border-start border-2 position-relative">
    <div class="card-header">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-file-earmark-arrow-up text-success me-2 text-primary"></i> Laporan UTS
        </h4>
    </div>
    <div class="card-body">
        <div>
            <button class="btn btn-outline-primary btn-sm me-2 toggle-laporan" type="button"
                data-target="#formLaporanUTS" aria-expanded="false" aria-controls="formLaporanUTS">
                <i class="bi bi-pencil-square me-1"></i> Isi Pelaporan UTS
            </button>
            @if($pelaporanUTS)
            <button class="btn btn-outline-secondary btn-sm toggle-laporan" type="button" data-target="#viewLaporanUTS"
                aria-expanded="false" aria-controls="viewLaporanUTS">
                <i class="bi bi-eye me-1"></i> Lihat Pelaporan UTS
            </button>
            @endif
        </div>

        @include('mahasiswa.pelaporan.partials.form-laporan', [
        'idCollapse' => 'formLaporanUTS',
        'action' => route('mahasiswa.pelaporan-pbl.laporan-uts.store'),
        'kode_tim' => $kode_tim,
        'pelaporan' => $pelaporanUTS,
        'prefix' => 'uts',
        'buttonClass' => 'btn-primary'
        ])

        @include('mahasiswa.pelaporan.partials.view-laporan', [
        'idCollapse' => 'viewLaporanUTS',
        'pelaporan' => $pelaporanUTS,
        'borderClass' => 'border-primary',
        'textColor' => 'text-primary',
        'btnColor' => 'btn-outline-primary'
        ])
    </div>
</div>
