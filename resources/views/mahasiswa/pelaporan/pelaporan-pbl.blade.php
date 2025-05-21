@extends('layouts.dashboardmahasiswa-template')

@section('title','Laporan PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Laporan PBL')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            @include('mahasiswa.pelaporan.partials.laporan-uts')
        </div>
        <div class="col-12">
            @include('mahasiswa.pelaporan.partials.laporan-uas')
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const allCollapseIds = ['#formLaporanUTS', '#viewLaporanUTS', '#formLaporanUAS', '#viewLaporanUAS'];
    const toggleButtons = document.querySelectorAll('.toggle-laporan');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetSelector = this.getAttribute('data-target');
            const targetEl = document.querySelector(targetSelector);

            // Tutup semua collapse lain kecuali target
            allCollapseIds.forEach(id => {
                if (id !== targetSelector) {
                    const el = document.querySelector(id);
                    const bsCollapse = bootstrap.Collapse.getInstance(el);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    } else {
                        new bootstrap.Collapse(el, { toggle: false }).hide();
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
