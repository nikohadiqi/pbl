@extends('layouts.dashboarddosen-template')

@section('title','Logbook | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Logbook Mingguan Tim PBL')
@section('page-title-1', 'Daftar Tim PBL')
@section('page-title-1-url', route('dosen.daftar-tim'))
@section('content')
<div class="container py-4">
    @for ($i = 1; $i <= 16; $i++)
        @php
            $tahapan = $tahapans->get($i - 1);
            $logbook = $logbooks->firstWhere('minggu', $i);
            $progress = $logbook ? $logbook->progress : 0;
            $maxScore = $scores[$i] ?? 100;
            $progressValue = min($progress, $maxScore);
            $radius = 45;
            $circumference = 2 * pi() * $radius;
            $offset = $circumference * (1 - ($progressValue / $maxScore));
        @endphp

        <div class="card shadow-sm my-4 border-start border-2 position-relative">
            <div class="position-absolute" style="top: 30px; right: 30px; width: 120px; height: 120px;">
                <svg width="120" height="120">
                    <circle cx="60" cy="60" r="{{ $radius }}" stroke="#e9ecef" stroke-width="5" fill="none" />
                    <circle cx="60" cy="60" r="{{ $radius }}" stroke="#F7CD07" stroke-width="5" fill="none"
                        stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $offset }}"
                        transform="rotate(-90 60 60)" />
                </svg>
                <div class="position-absolute top-50 start-50 translate-middle text-center small">
                    <strong style="font-size: 1.2rem;">{{ $progressValue }}%</strong>
                    <div class="text-muted" style="font-size: 0.75rem;">Progress</div>
                </div>
            </div>

            <div class="card-body">
                <h5 class="card-title mb-2">
                    <i class="bi bi-journal-check text-info me-2 text-primary"></i>Logbook Minggu Ke-{{ $i }}
                </h5>
                <p class="mb-3">
                    <strong class="text-muted">Tahapan:</strong>
                    {{ $tahapan ? $tahapan->tahapan : 'Belum ada tahapan' }}
                </p>

                @if($logbook)
                    <button class="btn btn-outline-primary btn-sm toggle-logbook" type="button"
                        data-target="#logbookView{{ $i }}" data-minggu="{{ $i }}">
                        <i class="bi bi-eye me-1"></i>Lihat Logbook
                    </button>
                    @include('mahasiswa.logbook.partials.view', [
                        'logbook' => $logbook,
                        'minggu' => $i
                    ])
                @else
                    <p class="text-muted fst-italic mt-2">Belum ada logbook minggu ini.</p>
                @endif
            </div>
        </div>
    @endfor
</div>
@endsection

@push('css')
<style>
    /* Border card warna kuning */
    .border-start.border-2 {
        border-color: #F7CD07 !important;
        /* bootstrap yellow */
    }

    /* Progress bar range track warna kuning */
    input[type="range"] {
        -webkit-appearance: none;
        width: 100%;
        height: 8px;
        border-radius: 5px;
        background: #e9ecef;
        outline: none;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #F7CD07;
        /* kuning */
        cursor: pointer;
        border: none;
        margin-top: -6px;
        /* supaya thumb tepat di tengah track */
    }

    input[type="range"]::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #F7CD07;
        /* kuning */
        cursor: pointer;
        border: none;
    }

    /* Progress circle stroke warna kuning */
    svg circle:nth-child(2) {
        stroke: #F7CD07 !important;
        transition: stroke-dashoffset 0.5s ease;
    }

    /* Border form input dan view logbook warna kuning */
    form.border,
    .collapse.border {
        border-color: #F7CD07 !important;
        background-color: #fff !important;
        /* background putih */
    }

    /* Kalau formnya pakai class .border, pastikan border kuning */
    form.border {
        border-width: 2px;
    }

    /* Container lihat logbook */
    .collapse .border {
        border-width: 2px;
        border-color: #F7CD07 !important;
        background-color: #fff !important;
    }

    .card {
        border-width: 1px;
        /* Mengurangi ketebalan border pada card */
    }

    .form-control {
        border-width: 1px;
        /* Mengurangi ketebalan border pada form input */
    }

    svg circle {
        stroke-width: 5 !important;
        /* Mengurangi ketebalan border pada progress circle */
    }
</style>
@endpush

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.toggle-logbook');

    toggles.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetEl = document.querySelector(targetId);

            // Tutup semua collapse yang sedang terbuka, kecuali target
            const allCollapses = document.querySelectorAll('[id^="logbookForm"], [id^="logbookView"]');
            allCollapses.forEach(el => {
                if (el !== targetEl && el.classList.contains('show')) {
                    const bsCollapse = bootstrap.Collapse.getInstance(el);
                    if(bsCollapse) {
                        bsCollapse.hide();
                    } else {
                        new bootstrap.Collapse(el, {toggle: false}).hide();
                    }
                }
            });

            // Toggle target collapse
            const bsTargetCollapse = bootstrap.Collapse.getInstance(targetEl);
            if(bsTargetCollapse) {
                bsTargetCollapse.toggle();
            } else {
                new bootstrap.Collapse(targetEl, {toggle: true});
            }
        });
    });
});
</script>
@endpush
