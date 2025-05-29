@extends('layouts.login-template')

@section('title', 'Tunggu Validasi | Sistem Informasi dan Monitoring Project Based Learning')

@section('main-content')
<section>
    <div class="page-header min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 text-center">
                    <img src="{{ url('assets/img/waiting-animation.gif') }}" alt="Menunggu Validasi"
                        class="img-fluid mb-4" style="max-height: 1000px;">
                    <h3 class="text-success fw-bold mt-3">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        Pendaftaran Berhasil!
                    </h3>
                    <p class="text-muted mt-2 mb-4">
                        Data tim telah diterima.<br>
                        Silakan tunggu akun divalidasi oleh Manajer Proyek untuk dapat masuk ke dalam sistem.
                    </p>

                    <!-- Informasi Tim -->
                    <div class="card shadow-sm border-0 text-start">
                        <div class="card-body">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-people-fill me-2"></i>Informasi Tim
                            </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Kelas:</strong> {{ $tim['kelas'] }}</li>
                                <li class="list-group-item"><strong>Kelompok:</strong> {{ $tim['kelompok'] }}</li>
                                <li class="list-group-item"><strong>Periode:</strong> Semester {{ $tim['periode']['semester'] }} - {{ $tim['periode']['tahun'] }}</li>
                                <li class="list-group-item"><strong>Manajer Proyek:</strong> {{ $tim['manpro'] }}</li>
                                <li class="list-group-item"><strong>Anggota:</strong>
                                    <ul class="mt-1">
                                        @foreach($tim['anggota'] as $anggota)
                                            <li>{{ $anggota['nim'] }} - {{ $anggota['nama'] }}</li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <a href="{{ route('login') }}" class="btn btn-primary mt-4 px-5">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
