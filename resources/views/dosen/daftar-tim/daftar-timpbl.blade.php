@extends('layouts.dashboarddosen-template')

@section('title','Daftar Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Daftar Tim PBL')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4 shadow-sm rounded-3" style="background-color: #fff;">
        {{-- FORM FILTER --}}
        <div class="mb-3">
            <form method="POST" action="#">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <select name="kelas" class="form-control">
                            <option value="">-- Pilih Kelas --</option>
                            <option value="4A">4A</option>
                            <option value="4B">4B</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <select name="tahun" class="form-control">
                            <option value="">-- Pilih Periode PBL --</option>
                            <option value="1">Semester 4 / Tahun 2025</option>
                            <option value="2">Semester 5 / Tahun 2025</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                    </div>
                </div>
            </form>
            <hr class="horizontal dark mt-2">
        </div>

        {{-- Card Tim PBL --}}
        @for ($i = 1; $i <= 5; $i++)
        <div class="card mb-3 border rounded-3">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                <div style="flex: 1">
                    <p class="mb-1"><strong>Nomor ID:</strong> PBL-00{{ $i }}</p>
                    <h5 class="mb-1"><strong>Judul Proyek {{ $i }}</strong></h5>
                    <p class="mb-1">Manajer Proyek: Nama Manajer {{ $i }}</p>
                    <p class="mb-2">Tim:</p>
                    <ul class="mb-3">
                        <li>Anggota 1</li>
                        <li>Anggota 2</li>
                        <li>Anggota 3</li>
                        <li>Anggota 4</li>
                        <li>Anggota 5</li>
                    </ul>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('dosen.daftar-tim.logbook') }}" class="btn btn-dark btn-sm">Lihat Logbook</a>
                        <a href="{{ route('dosen.daftar-tim.laporan') }}" class="btn btn-dark btn-sm">Lihat Laporan</a>
                        <a href="{{ route('dosen.daftar-tim.penilaian') }}" class="btn btn-dark btn-sm">Penilaian Mahasiswa</a>
                    </div>
                </div>
                <div class="text-center mt-3 mt-md-0" style="width: 150px;">
                    <div class="position-relative">
                        <svg width="120" height="120">
                            <circle cx="60" cy="60" r="50" stroke="#eee" stroke-width="10" fill="none" />
                            <circle cx="60" cy="60" r="50" stroke="#000" stroke-width="10" fill="none"
                                stroke-dasharray="{{ 2 * 3.14 * 50 }}"
                                stroke-dashoffset="{{ 2 * 3.14 * 50 * (1 - 0.82) }}" stroke-linecap="round"
                                transform="rotate(-90 60 60)" />
                        </svg>
                        <div class="position-absolute top-50 start-50 translate-middle text-center">
                            <strong style="font-size: 1.5rem;">85%</strong><br><small>Progres</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection
