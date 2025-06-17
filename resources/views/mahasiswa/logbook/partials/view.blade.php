@if($logbook)
<div class="collapse mt-3" id="logbookView{{ $minggu }}">
    <div class="border p-3 rounded rounded-3 bg-light">
        <p><strong>Aktivitas:</strong> {{ $logbook->aktivitas ?? '-' }}</p>
        <div class="form-group mt-2">
        <h6><i class="bi bi-file-earmark-pdf-fill me-1 text-danger"></i>HASIL/BUKTI</h6>
        @if($logbook && $logbook->hasil)
            <a href="{{ asset('storage/' . $logbook->hasil) }}" target="_blank"
                class="btn {{ $btnColor ?? 'btn-outline-primary' }} btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Lihat Hasil
            </a>
        @else
            <p class="text-muted fst-italic">Tidak ada hasil/bukti PDF yang diupload.</p>
        @endif

    </div>

        @if (!empty($logbook->foto_kegiatan))
        <div class="mt-2 mb-2">
            <p><strong>Foto:</strong><br>
                <a href="{{ url('storage/' . $logbook->foto_kegiatan) }}" download>
                    <img src="{{ url('storage/' . $logbook->foto_kegiatan) }}" class="rounded shadow-sm" width="120"
                        title="Klik untuk mengunduh">
                </a>
            </p>
            <div>
                <a href="{{ url('storage/' . $logbook->foto_kegiatan) }}" download
                    class="text-decoration-none small text-muted">
                    <i class="bi bi-download me-1"></i>Unduh Foto
                </a>
            </div>
        </div>
        @endif
        <p><strong>Kontribusi Anggota:</strong></p>
        <ul>
            @for ($j = 1; $j <= 5; $j++) @php $anggota=$logbook->{'anggota'.$j}; @endphp
                @if ($anggota)
                <li>{{ $anggota }}</li>
                @endif
                @endfor
        </ul>
        <p><strong>Progress:</strong> {{ $logbook->progress ?? 0 }}%</p>
        <p class="text-muted mt-2">
            <i class="bi bi-person-circle me-1"></i>
            <strong>Terakhir diperbarui oleh:</strong> {{ $logbook->updated_by }}
        </p>
    </div>
</div>
@endif
