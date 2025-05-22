@extends('layouts.dashboarddosen-template')

@section('title','Laporan PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Laporan Tim PBL')
@section('page-title-1', 'Daftar Tim PBL')
@section('page-title-1-url', route('dosen.daftar-tim'))
@section('content')
<div class="container mt-4">
    <div class="row">
        {{-- UTS --}}
        <div class="col-12">
            <div class="card shadow-sm border-start border-2 position-relative">
                <div class="card-header">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-file-earmark-arrow-up text-success me-2 text-primary"></i> Laporan UTS
                    </h4>
                </div>
                <div class="card-body">
                    @if($pelaporanUTS)
                    <button class="btn btn-outline-primary btn-sm toggle-laporan mb-3" type="button"
                        data-target="#viewLaporanUTS" aria-expanded="false" aria-controls="viewLaporanUTS">
                        <i class="bi bi-eye me-1"></i> Lihat Pelaporan UTS
                    </button>

                    @include('mahasiswa.pelaporan.partials.view-laporan', [
                    'idCollapse' => 'viewLaporanUTS',
                    'pelaporan' => $pelaporanUTS,
                    'borderClass' => 'border-primary',
                    'textColor' => 'text-primary',
                    'btnColor' => 'btn-outline-primary'
                    ])
                    @else
                    <p class="text-muted fst-italic">Belum ada laporan UTS yang diunggah.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- UAS --}}
        <div class="col-12">
            <div class="card shadow-sm my-4 border-start border-2 position-relative">
                <div class="card-header">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-file-earmark-arrow-up text-success me-2 text-success"></i> Laporan UAS
                    </h4>
                </div>
                <div class="card-body">
                    @if($pelaporanUAS)
                    <button class="btn btn-outline-primary btn-sm toggle-laporan mb-3" type="button"
                        data-target="#viewLaporanUAS" aria-expanded="false" aria-controls="viewLaporanUAS">
                        <i class="bi bi-eye me-1"></i> Lihat Pelaporan UAS
                    </button>

                    @include('mahasiswa.pelaporan.partials.view-laporan', [
                    'idCollapse' => 'viewLaporanUAS',
                    'pelaporan' => $pelaporanUAS,
                    'borderClass' => 'border-primary',
                    'textColor' => 'text-primary',
                    'btnColor' => 'btn-outline-success'
                    ])
                    @else
                    <p class="text-muted fst-italic">Belum ada laporan UAS yang diunggah.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const allCollapseIds = ['#viewLaporanUTS', '#viewLaporanUAS'].filter(id => document.querySelector(id) !== null);
    const toggleButtons = document.querySelectorAll('.toggle-laporan');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetSelector = this.getAttribute('data-target');
            const targetEl = document.querySelector(targetSelector);

            // Pastikan target ada
            if (!targetEl) return;

            // Tutup semua collapse lain kecuali target yang diklik
            allCollapseIds.forEach(id => {
                if (id !== targetSelector) {
                    const el = document.querySelector(id);
                    if (el) {
                        const bsCollapse = bootstrap.Collapse.getInstance(el);
                        if (bsCollapse) {
                            bsCollapse.hide();
                        } else {
                            new bootstrap.Collapse(el, { toggle: false }).hide();
                        }
                    }
                }
            });

            // Toggle target collapse
            const bsTargetCollapse = bootstrap.Collapse.getInstance(targetEl);
            if (bsTargetCollapse) {
                bsTargetCollapse.toggle();
            } else {
                new bootstrap.Collapse(targetEl, { toggle: true });
            }
        });
    });
});
</script>
@endpush
