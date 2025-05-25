<div class="tab-pane fade {{ session('active_step', 'step1') == 'step1' ? 'show active' : '' }}" id="step1"
    role="tabpanel">
    <form method="POST" action="{{ route('mahasiswa.rpp.rencana-proyek.store') }}">
        
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
                    <input type="text" name="biaya" id="biaya" class="form-control border-left-0" placeholder="1.000.000"
                        value="{{ old('biaya', $rencanaProyek->biaya ?? '') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Klien</label>
                <input type="text" name="klien" class="form-control" value="{{ old('klien', $rencanaProyek->klien ?? '') }}">
            </div>

            <div class="form-group col-md-6">
                <label>Estimasi Waktu</label>
                <input type="text" name="waktu" class="form-control" value="{{ old('waktu', $rencanaProyek->waktu ?? '') }}">
            </div>
        </div>

        <div class="form-group mb-3">
            <label>Luaran</label>
            <textarea name="luaran" class="form-control" rows="3" >{{ old('luaran', $rencanaProyek->luaran ?? '') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Ruang Lingkup</label>
            <textarea name="ruang_lingkup"
                class="form-control" rows="3">{{ old('ruang_lingkup', $rencanaProyek->ruang_lingkup ?? '') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Rancangan Sistem</label>
            <textarea name="rancangan_sistem"
                class="form-control" rows="3">{{ old('rancangan_sistem', $rencanaProyek->rancangan_sistem ?? '') }}</textarea>
        </div>
        <div class="form-group mb-3">
            <label>Evaluasi</label>
            <textarea name="rancangan_sistem"
                class="form-control" rows="3">{{ old('evaluasi', $rencanaProyek->evaluasi ?? '') }}</textarea>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-primary btn-next" data-next="#step2">Next</button>
            <a href="{{ route('mahasiswa.rpp.rencana-proyek.export') }}" class="btn btn-primary mb-3">
    <i class="fas fa-file-word"></i> Export ke Word
</a>

        </div>
    </form>
</div>
