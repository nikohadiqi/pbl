<div class="tab-pane fade {{ session('active_step', 'step1') == 'step1' ? 'show active' : '' }}" id="step1"
    role="tabpanel">
    <form method="POST" action="{{ route('mahasiswa.rpp.rencana-proyek.store') }}" id="rencanaForm">

        @csrf
        <h4 class="mb-4">Deskripsi Proyek</h4>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="kode_tim">Kode Tim</label>
                <input type="text" class="form-control" id="kode_tim"
                    value="{{ $rencanaProyek->kode_tim ?? $manajerProyek['kode_tim'] ?? $kodeTim ?? '-' }}" disabled>
            </div>

            <div class="form-group col-md-6">
                <label for="manajer_proyek">Manajer Proyek</label>
                <input type="text" name="manajer_proyek" class="form-control"
                    value="{{ $manajerProyek['nama'] ?? old('manajer_proyek', $rencanaProyek->manajer_proyek ?? '') }}"
                    readonly>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Judul Proyek <span class="text-danger" title="Wajib Diisi">*</span></label>
                <input type="text" name="judul_proyek" class="form-control"
                    value="{{ old('judul_proyek', $rencanaProyek->judul_proyek ?? '') }}">
            </div>

            <div class="form-group col-md-6">
                <label>Pengusul Proyek <span class="text-danger" title="Wajib Diisi">*</span></label>
                <input type="text" name="pengusul_proyek" class="form-control"
                    value="{{ old('pengusul_proyek', $rencanaProyek->pengusul_proyek ?? '') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Sponsor</label>
                <input type="text" name="sponsor" class="form-control"
                    value="{{ old('sponsor', $rencanaProyek->sponsor ?? '') }}">
            </div>

            <div class="form-group col-md-6">
                <label for="biaya" class="font-weight-bold">Biaya</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="text" name="biaya" id="biaya" class="form-control border-left-0"
                        placeholder="1.000.000" value="{{ old('biaya', $rencanaProyek->biaya ?? '') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Klien</label>
                <input type="text" name="klien" class="form-control"
                    value="{{ old('klien', $rencanaProyek->klien ?? '') }}">
            </div>

            <div class="form-group col-md-6">
                <label>Estimasi Waktu</label>
                <input type="text" name="waktu" class="form-control"
                    value="{{ old('waktu', $rencanaProyek->waktu ?? '') }}">
            </div>
        </div>

        <div class="form-group mb-3">
            <label>Luaran</label>
            <textarea name="luaran" class="form-control"
                rows="3">{{ old('luaran', $rencanaProyek->luaran ?? '') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Ruang Lingkup</label>
            <input type="hidden" name="ruang_lingkup" id="ruang_lingkup_input">
            <div id="ruang_lingkup_editor" style="height: 200px;"
                data-content="{!! htmlspecialchars(old('ruang_lingkup', $rencanaProyek->ruang_lingkup ?? '')) !!}">
            </div>
        </div>

        <div class="form-group mb-3">
            <label>Rancangan Sistem</label>
            <input type="hidden" name="rancangan_sistem" id="rancangan_sistem_input">
            <div id="rancangan_sistem_editor" style="height: 200px;"
                data-content="{!! htmlspecialchars(old('rancangan_sistem', $rencanaProyek->rancangan_sistem ?? '')) !!}">
            </div>
        </div>

        <div class="form-group mb-3">
            <label>Evaluasi</label>
            <input type="hidden" name="evaluasi" id="evaluasi_input">
            <div id="evaluasi_editor" style="height: 200px;"
                data-content="{!! htmlspecialchars(old('evaluasi', $rencanaProyek->evaluasi ?? '')) !!}">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success"><i class="bi bi-floppy me-1"></i> Simpan</button>
            <button type="button" class="btn btn-primary btn-next" data-next="#step2">Next</button>
        </div>
    </form>
</div>
