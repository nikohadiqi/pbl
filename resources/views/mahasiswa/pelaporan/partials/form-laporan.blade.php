<div class="collapse mt-3 px-4" id="{{ $idCollapse }}">
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data"
        class="border rounded rounded-3 p-3 {{ $borderClass ?? 'border-primary' }}">
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <input type="hidden" name="kode_tim" value="{{ $kode_tim }}">

        <div class="form-group">
            <label for="keterangan_{{ $prefix }}" class="form-label fw-semibold">Keterangan <span class="text-danger" title="Wajib Diisi">*</span></label>
            <textarea name="keterangan" id="keterangan_{{ $prefix }}" class="form-control" rows="5"
                placeholder="Jelaskan mengenai kegiatan PBL yang dikerjakan..">{{ old('keterangan', $pelaporan->keterangan ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="link_drive_{{ $prefix }}" class="form-label fw-semibold">Link Drive Laporan <span class="text-danger" title="Wajib Diisi">*</span></label>
            <input class="form-control" name="link_drive" id="link_drive_{{ $prefix }}" type="url"
                placeholder="Masukkan Link Drive" value="{{ old('link_drive', $pelaporan->link_drive ?? '') }}">
        </div>

        <div class="form-group">
            <label for="link_youtube_{{ $prefix }}" class="form-label fw-semibold">Link Youtube Proyek PBL</label>
            <input class="form-control" name="link_youtube" id="link_youtube_{{ $prefix }}" type="url"
                placeholder="Masukkan Link Youtube" value="{{ old('link_youtube', $pelaporan->link_youtube ?? '') }}">
        </div>

        <div class="form-group">
            <label for="laporan_pdf_{{ $prefix }}" class="form-label fw-semibold">Upload Laporan PDF <i
                    class="bi bi-file-earmark-pdf-fill text-danger">(Maks. 10 MB)</i></label>
            <input class="form-control @error('laporan_pdf') is-invalid @enderror" name="laporan_pdf"
                id="laporan_pdf_{{ $prefix }}" type="file" accept="application/pdf">
            @error('laporan_pdf')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn {{ $buttonClass ?? 'btn-primary' }} fw-semibold mt-2">
            <i class="bi bi-save2 me-1"></i> Simpan Pelaporan
        </button>
    </form>
</div>
