@extends('layouts.dashboardmahasiswa-template')

@section('title','Logbook Mingguan | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Logbook Mingguan')

@section('content')
<div class="container py-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @for ($i = 1; $i <= 16; $i++) @php $tahapan=$tahapans->get($i - 1);
        $logbook = $logbooks->firstWhere('minggu', $i);
        $progress = $logbook ? $logbook->progress : 0;
        $maxScore = $scores[$i] ?? 100;
        $initialProgress = old('progress', $progress);
        $progressValue = min($initialProgress, $maxScore);
        $radius = 45;
        $circumference = 2 * pi() * $radius;
        $offset = $circumference * (1 - ($progressValue / $maxScore));
        @endphp

        <div class="card shadow-sm my-4 border-start border-2 position-relative">
            <!-- Progress Circle -->
            <div class="position-absolute" style="top: 30px; right: 30px; width: 120px; height: 120px;">
                <svg width="120" height="120">
                    <circle cx="60" cy="60" r="{{ $radius }}" stroke="#e9ecef" stroke-width="5" fill="none" />
                    <circle cx="60" cy="60" r="{{ $radius }}" stroke="#dfa02c" stroke-width="5" fill="none"
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

                <p class="mb-1">
                    <strong class="text-muted">Tahapan:</strong>
                    {{ $tahapan ? $tahapan->tahapan : 'Belum ada tahapan' }}
                </p>

                <!-- Buttons -->
                <div class="form-group mt-3">
                    <!-- Tombol Isi Logbook -->
                    <button class="btn btn-outline-primary btn-sm me-2 toggle-logbook" type="button"
                        data-target="#logbookForm{{ $i }}" data-minggu="{{ $i }}">
                        <i class="bi bi-pencil-square me-1"></i>Isi Logbook
                    </button>

                    @if($logbook)
                    <!-- Tombol Lihat Logbook -->
                    <button class="btn btn-outline-secondary btn-sm toggle-logbook" type="button"
                        data-target="#logbookView{{ $i }}" data-minggu="{{ $i }}">
                        <i class="bi bi-eye me-1"></i>Lihat Logbook
                    </button>
                    @endif
                </div>

                @include('mahasiswa.logbook.partials.form', ['logbook' => $logbook, 'minggu' => $i, 'tahapan'
                => $tahapan, 'maxScore' => $maxScore])

                @if($logbook)
                @include('mahasiswa.logbook.partials.view', ['logbook' => $logbook, 'minggu' => $i])
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
        border-color: #dfa02c !important;
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
        background: #dfa02c;
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
        background: #dfa02c;
        /* kuning */
        cursor: pointer;
        border: none;
    }

    /* Progress circle stroke warna kuning */
    svg circle:nth-child(2) {
        stroke: #dfa02c !important;
        transition: stroke-dashoffset 0.5s ease;
    }

    /* Border form input dan view logbook warna kuning */
    form.border,
    .collapse.border {
        border-color: #dfa02c !important;
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
        border-color: #dfa02c !important;
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

@push('js')
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

