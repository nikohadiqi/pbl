@extends('layouts.dashboardmahasiswa-template')

@section('title','Rencana Pelaksanaan Proyek | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container mt-5">
    <h2>Form Rencana Proyek</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form 
        action="{{ $rencanaProyek && $rencanaProyek->first() ? route('mahasiswa.rpp.rencana-proyek.update', $rencanaProyek->first()->id_proyek) : route('mahasiswa.rpp.rencana-proyek.store') }}" 
        method="POST"
    >
        @csrf
        @if($rencanaProyek && $rencanaProyek->first())
            @method('PUT')
        @endif

        <div class="tab-content" id="formTabsContent">
            {{-- Step 1 --}}
            <div class="tab-pane fade show active" id="step1" role="tabpanel">
                <h4>Step 1: Informasi Dasar</h4>
                <div class="form-group mb-3">
                    <label for="id_proyek">ID Proyek</label>
                    <input type="text" name="id_proyek" class="form-control" value="{{ old('id_proyek', $rencanaProyek->first()->id_proyek ?? '') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="judul_proyek">Judul Proyek</label>
                    <input type="text" name="judul_proyek" class="form-control" value="{{ old('judul_proyek', $rencanaProyek->first()->judul_proyek ?? '') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="pengusul_proyek">Pengusul Proyek</label>
                    <input type="text" name="pengusul_proyek" class="form-control" value="{{ old('pengusul_proyek', $rencanaProyek->first()->pengusul_proyek ?? '') }}" required>
                </div>
                <button type="button" class="btn btn-primary btn-next" data-next="#step2">Next</button>
            </div>

            {{-- Step 2 --}}
            <div class="tab-pane fade" id="step2" role="tabpanel">
                <h4>Step 2: Ruang Lingkup & Rancangan Sistem</h4>
                <div class="form-group mb-3">
                    <label for="luaran">Luaran</label>
                    <textarea name="luaran" class="form-control" rows="3" required>{{ old('luaran', $rencanaProyek->first()->luaran ?? '') }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="sponsor">Sponsor</label>
                    <textarea name="sponsor" class="form-control" rows="3" required>{{ old('sponsor', $rencanaProyek->first()->sponsor ?? '') }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="rancangan_sistem">Rancangan Sistem</label>
                    <textarea name="rancangan_sistem" class="form-control" rows="3" required>{{ old('rancangan_sistem', $rencanaProyek->first()->rancangan_sistem ?? '') }}</textarea>
                </div>
                <button type="button" class="btn btn-secondary btn-prev" data-prev="#step1">Previous</button>
                <button type="button" class="btn btn-primary btn-next" data-next="#step3">Next</button>
            </div>

            {{-- Step 3 --}}
            <div class="tab-pane fade" id="step3" role="tabpanel">
                <h4>Step 3: Tahapan Pelaksanaan & Kebutuhan Peralatan</h4>
                <div class="form-group mb-3">
                    <label for="tahapan_pelaksanaan">Tahapan Pelaksanaan</label>
                    <textarea name="tahapan_pelaksanaan" class="form-control" rows="3" required>{{ old('tahapan_pelaksanaan', $rencanaProyek->first()->tahapan_pelaksanaan ?? '') }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="kebutuhan_peralatan">Kebutuhan Peralatan</label>
                    <textarea name="kebutuhan_peralatan" class="form-control" rows="3" required>{{ old('kebutuhan_peralatan', $rencanaProyek->first()->kebutuhan_peralatan ?? '') }}</textarea>
                </div>
                <button type="button" class="btn btn-secondary btn-prev" data-prev="#step2">Previous</button>
                <button type="button" class="btn btn-primary btn-next" data-next="#step4">Next</button>
            </div>

            {{-- Step 4 --}}
            <div class="tab-pane fade" id="step4" role="tabpanel">
                <h4>Step 4: Tantangan & Estimasi Waktu</h4>
                <div class="form-group mb-3">
                    <label for="tantangan">Tantangan</label>
                    <textarea name="tantangan" class="form-control" rows="3" required>{{ old('tantangan', $rencanaProyek->first()->tantangan ?? '') }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="waktu">Estimasi Waktu</label>
                    <textarea name="waktu" class="form-control" rows="3" required>{{ old('waktu', $rencanaProyek->first()->waktu ?? '') }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="ruang_lingkup">Ruang Lingkup</label>
                    <textarea name="ruang_lingkup" class="form-control" rows="3" required>{{ old('ruang_lingkup', $rencanaProyek->first()->ruang_lingkup ?? '') }}</textarea>
                </div>
                <button type="button" class="btn btn-secondary btn-prev" data-prev="#step3">Previous</button>
                <button type="button" class="btn btn-primary btn-next" data-next="#step5">Next</button>
            </div>

            {{-- Step 5 --}}
            <div class="tab-pane fade" id="step5" role="tabpanel">
                <h4>Step 5: Klien & Biaya Proyek</h4>
                <div class="form-group mb-3">
                    <label for="klien">Klien</label>
                    <textarea name="klien" class="form-control" rows="3" required>{{ old('klien', $rencanaProyek->first()->klien ?? '') }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="biaya">Biaya</label>
                    <textarea name="biaya" class="form-control" rows="3" required>{{ old('biaya', $rencanaProyek->first()->biaya ?? '') }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="biaya_proyek">Biaya Proyek</label>
                    <textarea name="biaya_proyek" class="form-control" rows="3" required>{{ old('biaya_proyek', $rencanaProyek->first()->biaya_proyek ?? '') }}</textarea>
                </div>
                <button type="button" class="btn btn-secondary btn-prev" data-prev="#step4">Previous</button>
                <button type="button" class="btn btn-primary btn-next" data-next="#step6">Next</button>
            </div>

            {{-- Step 6 --}}
            <div class="tab-pane fade" id="step6" role="tabpanel">
                <h4>Step 6: Tim & Estimasi</h4>
                <div class="form-group mb-3">
                    <label for="estimasi">Estimasi</label>
                    <input type="text" name="estimasi" class="form-control" value="{{ old('estimasi', $rencanaProyek->first()->estimasi ?? '') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="tim_proyek">Tim Proyek</label>
                    <textarea name="tim_proyek" class="form-control" rows="3" required>{{ old('tim_proyek', $rencanaProyek->first()->tim_proyek ?? '') }}</textarea>
                </div>
                <button type="button" class="btn btn-secondary btn-prev" data-prev="#step5">Previous</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </form>
</div>

{{-- JS Tab Control --}}
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-next').forEach(button => {
            button.addEventListener('click', function () {
                let nextTab = this.getAttribute('data-next');
                document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('show', 'active'));
                document.querySelector(nextTab).classList.add('show', 'active');
            });
        });

        document.querySelectorAll('.btn-prev').forEach(button => {
            button.addEventListener('click', function () {
                let prevTab = this.getAttribute('data-prev');
                document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('show', 'active'));
                document.querySelector(prevTab).classList.add('show', 'active');
            });
        });
    });
</script>
@endpush
@endsection
