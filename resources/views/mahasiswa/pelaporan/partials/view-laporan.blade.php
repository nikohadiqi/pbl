<div class="collapse mt-3 px-4" id="{{ $idCollapse }}">
    @if($pelaporan)
    <div class="card card-body border {{ $borderClass ?? 'border-primary' }} shadow-sm">
        <div class="form-group">
            <h6><i class="bi bi-info-circle {{ $textColor ?? 'text-primary' }}"></i> Keterangan</h6>
            <p>{{ $pelaporan->keterangan }}</p>
        </div>

        <div class="form-group mt-2">
            <h6><i class="bi bi-link-45deg me-1 {{ $textColor ?? 'text-primary' }}"></i> Link Drive Laporan</h6>
            <a href="{{ $pelaporan->link_drive }}" target="_blank" class="text-decoration-none text-info">
                {{ $pelaporan->link_drive }}
            </a>
        </div>

        <div class="form-group mt-2">
            <h6><i class="bi bi-youtube me-1 text-danger"></i> Link Youtube Proyek PBL</h6>
            <a href="{{ $pelaporan->link_youtube }}" target="_blank" class="text-decoration-none text-info">
                {{ $pelaporan->link_youtube ?? 'Belum ada link Youtube yang di unggah' }}
            </a>
        </div>

        <div class="form-group mt-2">
            <h6><i class="bi bi-file-earmark-pdf-fill me-1 text-danger"></i> Laporan PDF</h6>
            @if($pelaporan->laporan_pdf)
            <a href="{{ url('storage/'.$pelaporan->laporan_pdf) }}" target="_blank"
                class="btn {{ $btnColor ?? 'btn-outline-primary' }} btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Lihat PDF
            </a>
        </div>
        @else
        <p class="text-muted fst-italic">Tidak ada laporan PDF yang diupload.</p>
        @endif
        <p class="text-muted mt-2">
            <i class="bi bi-person-circle me-1"></i>
            <strong>Terakhir diperbarui oleh:</strong> {{ $pelaporan->updated_by ?? '-' }}
        </p>
    </div>
    @endif
</div>
