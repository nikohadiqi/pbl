@extends('layouts.dashboardmahasiswa-template')

@section('title','Logbook Mingguan | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Logbook Mingguan')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    @for ($i = 1; $i <= 16; $i++)
        @php
            $tahapan = $tahapans->get($i - 1); // Ambil tahapan sesuai minggu
            $logbook = $logbooks->firstWhere('minggu', $i);
            $progress = $logbook ? $logbook->progress : 0;
            $circumference = 2 * pi() * 30; // r = 30
            $offset = $circumference - ($circumference * $progress / 100);
        @endphp

        <div class="card shadow-sm my-3 border position-relative">
            {{-- Lingkaran Progress di pojok kanan atas --}}
            <div class="position-absolute" style="top: 15px; right: 15px; width: 70px; height: 70px;">
                <svg width="70" height="70">
                    <circle cx="35" cy="35" r="30" stroke="#ccc" stroke-width="5" fill="none" />
                    <circle cx="35" cy="35" r="30" stroke="#28a745" stroke-width="5" fill="none"
                        stroke-dasharray="{{ $circumference }}"
                        stroke-dashoffset="{{ $offset }}"
                        transform="rotate(-90 35 35)" />
                </svg>
                <div class="position-absolute top-50 start-50 translate-middle text-center" style="font-size: 0.75rem;">
                    <strong>{{ $progress }}%</strong><br>
                    <small class="text-muted">Progress</small>
                </div>
            </div>

            <div class="card-body">
                <h6 class="mb-1">Logbook Minggu Ke-{{ $i }}</h6>

                <p class="fw-bold mb-1">
                    Tahapan Pelaksanaan Mingguan:
                    @if ($tahapan)
                        {{ $tahapan->tahapan }}
                    @else
                        <span class="text-muted">Belum ada tahapan</span>
                    @endif
                </p>

                <p class="mb-2">Keterangan: Tidak ada keterangan</p>

                <!-- Tombol Toggle Form -->
                <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#logbookForm{{ $i }}" aria-expanded="false" aria-controls="logbookForm{{ $i }}">
                    Isi Logbook
                </button>

                <!-- Form Input Logbook -->
                <div class="collapse" id="logbookForm{{ $i }}">
                    <form action="{{ route('mahasiswa.semester4.logbook.store') }}" method="POST" enctype="multipart/form-data" class="p-3">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Keterangan Aktivitas</label>
                            <input type="text" name="aktivitas" class="form-control" value="{{ old('aktivitas', optional($logbook)->aktivitas) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Hasil atau Bukti Pengerjaan (Bisa menyertakan link github / drive )</label>
                            <input type="text" name="hasil" class="form-control" value="{{ old('hasil', optional($logbook)->hasil) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Kegiatan</label>
                            <input type="file" name="foto_kegiatan" class="form-control">
                            @if (optional($logbook)->foto_kegiatan)
                                <img src="{{ asset('storage/' . $logbook->foto_kegiatan) }}" alt="Foto Kegiatan" class="mt-2" width="100">
                            @endif
                        </div>

                        <div class="row">
                            @for ($j = 1; $j <= 5; $j++)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Kontribusi Anggota (Contoh. Nama = Membantu dalam membuat design UI UX) {{ $j }}</label>
                                    <input type="text" name="anggota{{ $j }}" class="form-control" value="{{ old('anggota'.$j, optional($logbook)->{'anggota'.$j}) }}">
                                </div>
                            @endfor
                        </div>
              <div class="form-group mb-3">
                <label for="progress" class="form-label fw-semibold">Progress Proyek</label>
                    <input
                        type="range"
                        name="progress"
                        id="progress"
                        class="form-range me-3"
                        min="0"
                        max="100"
                        value="{{ old('progress', isset($logbook) ? $logbook->progress : 0) }}"
                        oninput="document.getElementById('progress-value').textContent = this.value + '%'"
                        style="flex: 1;"
                    >
                    <span id="progress-value" style="width: 50px; text-align: right;">
                        {{ old('progress', isset($logbook) ? $logbook->progress : 0) }}%
                    </span>
                </div>

                        <input type="hidden" name="minggu" value="{{ $i }}">

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Simpan Logbook</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endfor
</div>
@endsection
