@if($logbook)
<div class="collapse mt-3" id="logbookView{{ $minggu }}">
    <div class="border p-3 rounded rounded-3 bg-light">
        <p><strong>Aktivitas:</strong> {{ $logbook->aktivitas ?? '-' }}</p>
        <p><strong>Hasil:</strong> {{ $logbook->hasil ?? '-' }}</p>
        @if (!empty($logbook->foto_kegiatan))
        <div class="mt-2 mb-2">
            <p><strong>Foto:</strong><br>
                <a href="{{ asset('storage/' . $logbook->foto_kegiatan) }}" download>
                    <img src="{{ asset('storage/' . $logbook->foto_kegiatan) }}" class="rounded shadow-sm" width="120"
                        title="Klik untuk mengunduh">
                </a>
            </p>
            <div>
                <a href="{{ asset('storage/' . $logbook->foto_kegiatan) }}" download
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
