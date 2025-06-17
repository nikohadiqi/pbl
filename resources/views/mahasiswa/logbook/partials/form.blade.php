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
        <label for="hasil_{{ $prefix ?? 'logbook' }}" class="form-label fw-semibold">
            Hasil / Bukti Pengerjaan (dokumentasi, link github, dll dijadikan satu pada file PDF)
            <i class="bi bi-file-earmark-pdf-fill text-danger">(Maks. 10 MB)</i>
        </label>
        <input class="form-control @error('hasil') is-invalid @enderror"
            name="hasil"
            id="hasil_{{ $prefix ?? 'logbook' }}"
            type="file"
            accept="application/pdf">
        @error('hasil')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        {{-- ✅ Jika sudah ada PDF yang disimpan sebelumnya, tampilkan tombol lihat --}}
        @if (!empty($logbook->hasil))
            <div class="mt-2">
                <a href="{{ asset('storage/' . $logbook->hasil) }}" target="_blank"
                    class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-file-earmark-pdf"></i> Lihat Hasil PDF Sebelumnya
                </a>
            </div>
        @endif
    </div>



        <div class="form-group">
            <label class="form-label fw-semibold">Foto Kegiatan <i class="bi bi-image-fill text-info"> (Maks. 2 MB)</i></label>
            <input type="file" accept="image/png, image/jpeg, image/jpg, image/gif" name="foto_kegiatan" class="form-control">
            @if (!empty($logbook->foto_kegiatan))
            <div class="mt-2">
                <a href="{{ url('storage/' . $logbook->foto_kegiatan) }}" download>
                    <img src="{{ url('storage/' . $logbook->foto_kegiatan) }}" class="rounded shadow-sm" width="120"
                        title="Klik untuk mengunduh">
                </a>
                <div>
                    <a href="{{ url('storage/' . $logbook->foto_kegiatan) }}" download
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
                        this.style.background = 'linear-gradient(to right, #dfa02c ' + percent + '%, #dee2e6 ' + percent + '%)';
                    "
                    style="flex: 1; background: linear-gradient(to right, #dfa02c {{ ($progressValue / $maxScore) * 100 }}%, #dee2e6 {{ ($progressValue / $maxScore) * 100 }}%)">
                <span id="progress-value-{{ $minggu }}" style="width: 50px;">{{ $progressValue }}%</span>
            </div>
        </div>

        <input type="hidden" name="minggu" value="{{ $minggu }}">
        <input type="hidden" name="tahapan_id" value="{{ $tahapan ? $tahapan->id : '' }}">

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-floppy me-1"></i> Simpan Logbook
            </button>
        </div>
    </form>
</div>
