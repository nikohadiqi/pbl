@extends('layouts.dashboardmahasiswa-template')

@section('title','Rencana Pelaksanaan Proyek | Sistem Informasi dan Monitoring Project Based Learning')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active" id="step1-tab" data-toggle="pill" href="#step1">1 Deskripsi Proyek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step2-tab" data-toggle="pill" href="#step2">2 Ruang Lingkup & Rancangan
                        Sistem</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step3-tab" data-toggle="pill" href="#step3">3 Tahapan Pelaksanaan &
                        Kebutuhan Peralatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step4-tab" data-toggle="pill" href="#step4">4 Tantangan & Estimasi Waktu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step5-tab" data-toggle="pill" href="#step5">5 Biaya & Tim Proyek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step6-tab" data-toggle="pill" href="#step6">6 Mata Kuliah & Evaluasi</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="step1">
                    <h5 class="mb-3">Form Deskripsi Proyek PBL Mahasiswa</h5>
                    <form>
                        <div class="form-group">
                            <label>Nomor ID Proyek</label>
                            <input type="text" class="form-control" value="3A_1" readonly>
                        </div>
                        <div class="form-group">
                            <label>Judul Proyek PBL</label>
                            <input type="text" class="form-control" placeholder="Masukan Judul Proyek PBL">
                        </div>
                        <div class="form-group">
                            <label>Pengusul Proyek</label>
                            <input type="text" class="form-control" placeholder="Masukan Pengusul Proyek">
                        </div>
                        <div class="form-group">
                            <label>Manajer Proyek</label>
                            <input type="text" class="form-control" placeholder="Masukan Nama Manajer Proyek">
                        </div>
                        <div class="form-group">
                            <label>Luaran</label>
                            <input type="text" class="form-control" placeholder="Masukan Luaran Proyek PBL">
                        </div>
                        <div class="form-group">
                            <label>Sponsor</label>
                            <input type="text" class="form-control" placeholder="Masukan Sponsor dari Proyek PBL">
                        </div>
                        <div class="form-group">
                            <label>Biaya</label>
                            <input type="text" class="form-control" placeholder="Masukan Biaya Proyek PBL">
                        </div>
                        <div class="form-group">
                            <label>Klien/Pelanggan</label>
                            <input type="text" class="form-control" placeholder="Masukan Klien dari Proyek PBL">
                        </div>
                        <div class="form-group">
                            <label>Waktu</label>
                            <input type="text" class="form-control" placeholder="Masukan Waktu Pelaksanaan Proyek PBL">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-warning">SIMPAN</button>
                            <button type="button" class="btn btn-primary">SELANJUTNYA</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="step2">
                    <h5>Ruang Lingkup & Rancangan Sistem</h5>
                    <p>Isi form ini sesuai dengan proyek yang dirancang.</p>
                </div>
                <div class="tab-pane fade" id="step3">
                    <h5>Tahapan Pelaksanaan & Kebutuhan Peralatan</h5>
                    <p>Isi form ini sesuai dengan tahapan dan kebutuhan proyek.</p>
                </div>
                <div class="tab-pane fade" id="step4">
                    <h5>Tantangan & Estimasi Waktu</h5>
                    <p>Isi form ini dengan tantangan yang mungkin dihadapi.</p>
                </div>
                <div class="tab-pane fade" id="step5">
                    <h5>Biaya & Tim Proyek</h5>
                    <p>Isi form ini dengan informasi biaya dan tim proyek.</p>
                </div>
                <div class="tab-pane fade" id="step6">
                    <h5>Mata Kuliah & Evaluasi</h5>
                    <p>Isi form ini dengan mata kuliah terkait dan evaluasi proyek.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
