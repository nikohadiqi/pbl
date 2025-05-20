@extends('layouts.dashboardmahasiswa-template')

@section('title','Laporan PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Laporan PBL')

@section('content')
<div class="container mt-4">
    <div class="row g-4">

     <!-- Card Laporan UTS -->
        <div class="col-12">
            <div class="card shadow-lg h-100 card-hover border-success">
                <div class="card-header d-flex justify-content-between align-items-center bg-success text-white">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-journal-check me-2"></i> Laporan UTS
                    </h4>
                    <div>
                        <button class="btn btn-light btn-sm me-2" type="button" data-bs-toggle="collapse" data-bs-target="#formLaporanUTS" aria-expanded="false" aria-controls="formLaporanUTS">
                            <i class="bi bi-pencil-square me-1"></i> Isi Pelaporan UTS
                        </button>
                        @if($pelaporanUTS)
                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#viewLaporanUTS" aria-expanded="false" aria-controls="viewLaporanUTS">
                            <i class="bi bi-eye me-1"></i> Lihat Pelaporan UTS
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Form Isi Pelaporan UTS -->
                <div class="collapse mt-3 px-4" id="formLaporanUTS">
                    <form method="POST" action="{{ route('mahasiswa.pelaporan-pbl.laporan-uts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="kode_tim" value="{{ $kode_tim }}">

                        <div class="mb-3">
                            <label for="keterangan_uts" class="form-label fw-semibold">Keterangan <i class="bi bi-info-circle-fill text-info"></i></label>
                            <textarea name="keterangan" id="keterangan_uts" class="form-control" rows="5" placeholder="Jelaskan mengenai kegiatan PBL yang dikerjakan..">{{ old('keterangan', $pelaporanUTS->keterangan ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="link_drive_uts" class="form-label fw-semibold">Link Drive Laporan <i class="bi bi-link-45deg text-info"></i></label>
                            <input class="form-control" name="link_drive" id="link_drive_uts" placeholder="Masukan Link Drive" type="text" value="{{ old('link_drive', $pelaporanUTS->link_drive ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="link_youtube_uts" class="form-label fw-semibold">Link Youtube Proyek PBL <i class="bi bi-youtube text-danger"></i></label>
                            <input class="form-control" name="link_youtube" id="link_youtube_uts" placeholder="Masukan Link Youtube" type="text" value="{{ old('link_youtube', $pelaporanUTS->link_youtube ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="laporan_pdf_uts" class="form-label fw-semibold">Upload Laporan PDF <i class="bi bi-file-earmark-pdf-fill text-danger"></i></label>
                            <input class="form-control" name="laporan_pdf" id="laporan_pdf_uts" type="file" accept="application/pdf">
                        </div>

                        <button type="submit" class="btn btn-primary fw-semibold">
                            <i class="bi bi-save2 me-1"></i> Simpan Pelaporan UTS
                        </button>
                    </form>
                </div>

                <!-- View Pelaporan UTS -->
                <div class="collapse mt-3 px-4" id="viewLaporanUTS">
                    @if($pelaporanUTS)
                    <div class="card card-body border border-primary shadow-sm">
                        <h5><i class="bi bi-info-circle me-1 text-primary"></i> Keterangan:</h5>
                        <p>{{ $pelaporanUTS->keterangan }}</p>

                        <h5><i class="bi bi-link-45deg me-1 text-primary"></i> Link Drive Laporan:</h5>
                        <a href="{{ $pelaporanUTS->link_drive }}" target="_blank" class="text-decoration-none">{{ $pelaporanUTS->link_drive }}</a>

                        <h5><i class="bi bi-youtube me-1 text-danger"></i> Link Youtube Proyek PBL:</h5>
                        <a href="{{ $pelaporanUTS->link_youtube }}" target="_blank" class="text-decoration-none">{{ $pelaporanUTS->link_youtube }}</a>

                        <h5><i class="bi bi-file-earmark-pdf-fill me-1 text-danger"></i> Laporan PDF:</h5>
                        @if($pelaporanUTS->laporan_pdf)
                        <a href="{{ asset('storage/'.$pelaporanUTS->laporan_pdf) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Lihat PDF
                        </a>
                        @else
                        <p class="text-muted fst-italic">Tidak ada laporan PDF yang diupload.</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Laporan UAS -->
        <div class="col-12">
            <div class="card shadow-lg h-100 card-hover border-success">
                <div class="card-header d-flex justify-content-between align-items-center bg-success text-white">
                    <h4 class="fw-bold mb-0">
                        <i class="bi bi-journal-check me-2"></i> Laporan UAS
                    </h4>
                    <div>
                        <button class="btn btn-light btn-sm me-2" type="button" data-bs-toggle="collapse" data-bs-target="#formLaporanUAS" aria-expanded="false" aria-controls="formLaporanUAS">
                            <i class="bi bi-pencil-square me-1"></i> Isi Pelaporan UAS
                        </button>
                        @if($pelaporanUAS)
                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#viewLaporanUAS" aria-expanded="false" aria-controls="viewLaporanUAS">
                            <i class="bi bi-eye me-1"></i> Lihat Pelaporan UAS
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Form Isi Pelaporan UAS -->
                <div class="collapse mt-3 px-4" id="formLaporanUAS">
                    <form method="POST" action="{{ route('mahasiswa.pelaporan-pbl.laporan-uas.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="kode_tim" value="{{ $kode_tim }}">

                        <div class="mb-3">
                            <label for="keterangan_uas" class="form-label fw-semibold">Keterangan <i class="bi bi-info-circle-fill text-info"></i></label>
                            <textarea name="keterangan" id="keterangan_uas" class="form-control" rows="5" placeholder="Jelaskan mengenai kegiatan PBL yang dikerjakan..">{{ old('keterangan', $pelaporanUAS->keterangan ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="link_drive_uas" class="form-label fw-semibold">Link Drive Laporan <i class="bi bi-link-45deg text-info"></i></label>
                            <input class="form-control" name="link_drive" id="link_drive_uas" placeholder="Masukan Link Drive" type="text" value="{{ old('link_drive', $pelaporanUAS->link_drive ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="link_youtube_uas" class="form-label fw-semibold">Link Youtube Proyek PBL <i class="bi bi-youtube text-danger"></i></label>
                            <input class="form-control" name="link_youtube" id="link_youtube_uas" placeholder="Masukan Link Youtube" type="text" value="{{ old('link_youtube', $pelaporanUAS->link_youtube ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="laporan_pdf_uas" class="form-label fw-semibold">Upload Laporan PDF <i class="bi bi-file-earmark-pdf-fill text-danger"></i></label>
                            <input class="form-control" name="laporan_pdf" id="laporan_pdf_uas" type="file" accept="application/pdf">
                        </div>

                        <button type="submit" class="btn btn-success fw-semibold">
                            <i class="bi bi-save2 me-1"></i> Simpan Pelaporan UAS
                        </button>
                    </form>
                </div>

                <!-- View Pelaporan UAS -->
                <div class="collapse mt-3 px-4" id="viewLaporanUAS">
                    @if($pelaporanUAS)
                    <div class="card card-body border border-success shadow-sm">
                        <h5><i class="bi bi-info-circle me-1 text-success"></i> Keterangan:</h5>
                        <p>{{ $pelaporanUAS->keterangan }}</p>

                        <h5><i class="bi bi-link-45deg me-1 text-success"></i> Link Drive Laporan:</h5>
                        <a href="{{ $pelaporanUAS->link_drive }}" target="_blank" class="text-decoration-none">{{ $pelaporanUAS->link_drive }}</a>

                        <h5><i class="bi bi-youtube me-1 text-danger"></i> Link Youtube Proyek PBL:</h5>
                        <a href="{{ $pelaporanUAS->link_youtube }}" target="_blank" class="text-decoration-none">{{ $pelaporanUAS->link_youtube }}</a>

                        <h5><i class="bi bi-file-earmark-pdf-fill me-1 text-danger"></i> Laporan PDF:</h5>
                        @if($pelaporanUAS->laporan_pdf)
                        <a href="{{ asset('storage/'.$pelaporanUAS->laporan_pdf) }}" target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Lihat PDF
                        </a>
                        @else
                        <p class="text-muted fst-italic">Tidak ada laporan PDF yang diupload.</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
