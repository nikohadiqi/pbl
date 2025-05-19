@extends('layouts.dashboardmahasiswa-template')

@section('title','Logbook Mingguan | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Logbook Mingguan')

@section('content')
<style>
    /* Font lebih besar *
    .card, .form-label, .form-control, .btn {
        font-size: 1.1rem;
    }

    /* Border card warna kuning */
    .border-start.border-4 {
        border-color: #FFC107 !important; /* bootstrap yellow */
    }

    /* Form input dengan border merah */
    .form-control {
        border: 1.5px solid #dc3545; /* merah */
        transition: border-color 0.3s ease;
    }
    .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
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
        background: #FFC107; /* kuning */
        cursor: pointer;
        border: none;
        margin-top: -6px; /* supaya thumb tepat di tengah track */
    }
    input[type="range"]::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #FFC107; /* kuning */
        cursor: pointer;
        border: none;
    }

    /* Progress circle stroke warna kuning */
    svg circle:nth-child(2) {
        stroke: #FFC107 !important;
        transition: stroke-dashoffset 0.5s ease;
    }
            /* Border form input dan view logbook warna kuning */
        form.border, .collapse.border {
            border-color: #FFC107 !important;
            background-color: #fff !important; /* background putih */
        }

        /* Kalau formnya pakai class .border, pastikan border kuning */
        form.border {
            border-width: 2px;
        }

        /* Container lihat logbook */
        .collapse .border {
            border-width: 2px;
            border-color: #FFC107 !important;
            background-color: #fff !important;
        }
                .card {
            border-width: 1px; /* Mengurangi ketebalan border pada card */
        }

        .form-control {
            border-width: 1px; /* Mengurangi ketebalan border pada form input */
        }

        svg circle {
            stroke-width: 4; /* Mengurangi ketebalan border pada progress circle */
        }

</style>

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

    @for ($i = 1; $i <= 16; $i++)
        @php
            $tahapan = $tahapans->get($i - 1);
            $logbook = $logbooks->firstWhere('minggu', $i);
            $progress = $logbook ? $logbook->progress : 0;
            $maxScore = $scores[$i] ?? 100;
            $initialProgress = old('progress', $progress);
            $progressValue = min($initialProgress, $maxScore);
            $radius = 30;
            $circumference = 2 * pi() * $radius;
            $offset = $circumference * (1 - ($progressValue / $maxScore));
        @endphp

        <div class="card shadow-sm my-4 border-start border-4 position-relative">
            <!-- Progress Circle -->
            <div class="position-absolute" style="top: 15px; right: 15px; width: 70px; height: 70px;">
                <svg width="70" height="70">
                    <circle cx="35" cy="35" r="{{ $radius }}" stroke="#e9ecef" stroke-width="5" fill="none" />
                    <circle
                        cx="35" cy="35" r="{{ $radius }}"
                        stroke="#FFC107"
                        stroke-width="5"
                        fill="none"
                        stroke-dasharray="{{ $circumference }}"
                        stroke-dashoffset="{{ $offset }}"
                        transform="rotate(-90 35 35)"
                    />
                </svg>
                <div class="position-absolute top-50 start-50 translate-middle text-center small">
                    <strong>{{ $progressValue }}%</strong>
                    <div class="text-muted" style="font-size: 0.7rem;">Progress</div>
                </div>
            </div>

            <div class="card-body">
                <h5 class="card-title mb-2">
                    <i class="bi bi-journal-check me-2 text-primary"></i>Logbook Minggu Ke-{{ $i }}
                </h5>

                <p class="mb-1">
                    <strong class="text-muted">Tahapan:</strong>
                    {{ $tahapan ? $tahapan->tahapan : 'Belum ada tahapan' }}
                </p>
                <p class="text-muted small">Keterangan: Tidak ada keterangan</p>

                <!-- Buttons -->
                <div class="mb-3">
                    <button class="btn btn-outline-primary btn-sm me-2" type="button" data-bs-toggle="collapse" data-bs-target="#logbookForm{{ $i }}">
                        <i class="bi bi-pencil-square me-1"></i>Isi Logbook
                    </button>
                    @if($logbook)
                        <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#logbookView{{ $i }}">
                            <i class="bi bi-eye me-1"></i>Lihat Logbook
                        </button>
                    @endif
                </div>

                <!-- Form Input -->
                <div class="collapse" id="logbookForm{{ $i }}">
                    <form action="{{ route('mahasiswa.semester4.logbook.store') }}" method="POST" enctype="multipart/form-data" class="border rounded p-3 bg-light">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Keterangan Aktivitas</label>
                            <input type="text" name="aktivitas" class="form-control" value="{{ old('aktivitas', optional($logbook)->aktivitas) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Hasil / Bukti Pengerjaan (Github/Drive)</label>
                            <input type="text" name="hasil" class="form-control" value="{{ old('hasil', optional($logbook)->hasil) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Kegiatan</label>
                            <input type="file" name="foto_kegiatan" class="form-control">
                            @if (optional($logbook)->foto_kegiatan)
                                <img src="{{ asset('storage/' . $logbook->foto_kegiatan) }}" class="mt-2 rounded shadow-sm" width="120">
                            @endif
                        </div>

                        @for ($j = 1; $j <= 5; $j++)
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kontribusi Anggota {{ $j }}</label>
                                <input type="text" name="anggota{{ $j }}" class="form-control" value="{{ old('anggota'.$j, optional($logbook)->{'anggota'.$j}) }}">
                            </div>
                        @endfor

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Progress Proyek (max {{ $maxScore }}%)</label>
                            <div class="d-flex align-items-center">
                                <input
                                    type="range"
                                    name="progress"
                                    id="progress{{ $i }}"
                                    class="form-range me-3"
                                    min="0"
                                    max="{{ $maxScore }}"
                                    value="{{ $progressValue }}"
                                    oninput="
                                        const val = Math.min(this.value, {{ $maxScore }});
                                        document.getElementById('progress-value-{{ $i }}').textContent = val + '%';
                                        const percent = (val / {{ $maxScore }}) * 100;
                                        this.style.background = 'linear-gradient(to right, #FFC107 ' + percent + '%, #dee2e6 ' + percent + '%)';
                                    "
                                    style="flex: 1; background: linear-gradient(to right, #FFC107 {{ ($progressValue / $maxScore) * 100 }}%, #dee2e6 {{ ($progressValue / $maxScore) * 100 }}%)"
                                >
                                <span id="progress-value-{{ $i }}" style="width: 50px;">{{ $progressValue }}%</span>
                            </div>
                        </div>

                        <input type="hidden" name="minggu" value="{{ $i }}">
                        <input type="hidden" name="tahapan_id" value="{{ $tahapan ? $tahapan->id : '' }}">

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i>Simpan Logbook
                            </button>
                        </div>
                    </form>
                </div>

                <!-- View Logbook -->
                @if($logbook)
                    <div class="collapse mt-3" id="logbookView{{ $i }}">
                        <div class="border p-3 rounded bg-light">
                            <p><strong>Aktivitas:</strong> {{ $logbook->aktivitas ?? '-' }}</p>
                            <p><strong>Hasil:</strong> {{ $logbook->hasil ?? '-' }}</p>
                            @if($logbook->foto_kegiatan)
                                <p><strong>Foto:</strong><br>
                                    <img src="{{ asset('storage/' . $logbook->foto_kegiatan) }}" alt="Foto" class="rounded shadow-sm" width="150">
                                </p>
                            @endif
                            <p><strong>Kontribusi Anggota:</strong></p>
                            <ul>
                                @for ($j = 1; $j <= 5; $j++)
                                    @php $anggota = $logbook->{'anggota'.$j}; @endphp
                                    @if ($anggota)
                                        <li>{{ $anggota }}</li>
                                    @endif
                                @endfor
                            </ul>
                            <p><strong>Progress:</strong> {{ $logbook->progress ?? 0 }}%</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endfor
</div>
@endsection
