@php
    $progressValue = min(old('progress', $logbook->progress ?? 0), $maxScore);
@endphp

<div class="collapse mt-3" id="logbookForm{{ $minggu }}">
    <form action="{{ route('mahasiswa.logbook.store') }}" method="POST" enctype="multipart/form-data"
        class="border rounded rounded-3 p-3 bg-light">
        @csrf

        <div class="form-group">
            <label class="form-label fw-semibold">Keterangan Aktivitas <span class="text-danger" title="Wajib Diisi">*</span></label>
            <input type="text" name="aktivitas" class="form-control" value="{{ old('aktivitas', $logbook->aktivitas ?? '') }}">
        </div>

        <div class="form-group">
            <label class="form-label fw-semibold">Hasil / Bukti Pengerjaan (Github/Drive) <span class="text-danger" title="Wajib Diisi">*</span></label>
            <input type="text" name="hasil" class="form-control" value="{{ old('hasil', $logbook->hasil ?? '') }}">
        </div>

        <div class="form-group">
            <label class="form-label fw-semibold">Foto Kegiatan <i class="bi bi-image-fill text-info"> (Maks. 2 MB)</i></label>
            <input type="file" accept="image/png, image/jpeg, image/jpg, image/gif" name="foto_kegiatan" class="form-control">
            @if (!empty($logbook->foto_kegiatan))
            <div class="mt-2">
                <a href="{{ asset('storage/' . $logbook->foto_kegiatan) }}" download>
                    <img src="{{ asset('storage/' . $logbook->foto_kegiatan) }}" class="rounded shadow-sm" width="120"
                        title="Klik untuk mengunduh">
                </a>
                <div>
                    <a href="{{ asset('storage/' . $logbook->foto_kegiatan) }}" download
                        class="text-decoration-none small text-muted">
                        <i class="bi bi-download me-1"></i>Unduh Foto
                    </a>
                </div>
            </div>
            @endif
        </div>

        @for ($j = 1; $j <= 5; $j++)
            <div class="form-group">
                <label class="form-label fw-semibold">Kontribusi Anggota {{ $j }}</label>
                <input type="text" name="anggota{{ $j }}" class="form-control"
                    value="{{ old('anggota'.$j, $logbook->{'anggota'.$j} ?? '') }}">
            </div>
        @endfor

        <div class="form-group">
            <label class="form-label fw-semibold">Progress Proyek (max {{ $maxScore }}%) <span class="text-danger" title="Wajib Diisi">*</span></label>
            <div class="d-flex align-items-center">
                <input type="range" name="progress" id="progress{{ $minggu }}" class="form-range me-3" min="0"
                    max="{{ $maxScore }}" value="{{ $progressValue }}" oninput="
                        const val = Math.min(this.value, {{ $maxScore }});
                        document.getElementById('progress-value-{{ $minggu }}').textContent = val + '%';
                        const percent = (val / {{ $maxScore }}) * 100;
                        this.style.background = 'linear-gradient(to right, #F7CD07 ' + percent + '%, #dee2e6 ' + percent + '%)';
                    "
                    style="flex: 1; background: linear-gradient(to right, #F7CD07 {{ ($progressValue / $maxScore) * 100 }}%, #dee2e6 {{ ($progressValue / $maxScore) * 100 }}%)">
                <span id="progress-value-{{ $minggu }}" style="width: 50px;">{{ $progressValue }}%</span>
            </div>
        </div>

        <input type="hidden" name="minggu" value="{{ $minggu }}">
        <input type="hidden" name="tahapan_id" value="{{ $tahapan ? $tahapan->id : '' }}">

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i>Simpan Logbook
            </button>
        </div>
    </form>
</div>
