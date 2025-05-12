@extends('layouts.dashboardmahasiswa-template')

@section('title','Logbook Mingguan | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Logbook Mingguan')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    @for ($i = 1; $i <= 16; $i++)
        <div class="card shadow-sm my-3 border">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">Logbook Minggu Ke-{{ $i }}</h6>
                    <p class="fw-bold mb-1">Tahapan Pelaksanaan Mingguan</p>
                    <p class="mb-2">Keterangan: Tidak ada keterangan</p>

                    <!-- Button to toggle dropdown -->
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#logbookForm{{ $i }}" aria-expanded="false" aria-controls="logbookForm{{ $i }}">
                        Isi Logbook
                    </button>
                </div>
            </div>

            <!-- Dropdown form to fill logbook -->
            <div class="collapse" id="logbookForm{{ $i }}">
                <form action="{{ route('mahasiswa.semester4.logbook.logbook.store') }}" method="POST" enctype="multipart/form-data" class="p-3">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Aktivitas</label>
                        <input type="text" name="aktivitas" class="form-control" value="{{ old('aktivitas', optional($logbooks->firstWhere('minggu', $i))->aktivitas) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Hasil</label>
                        <input type="text" name="hasil" class="form-control" value="{{ old('hasil', optional($logbooks->firstWhere('minggu', $i))->hasil) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Progress (%)</label>
                        <input type="number" name="progress" class="form-control" min="0" max="100" value="{{ old('progress', optional($logbooks->firstWhere('minggu', $i))->progress) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Kegiatan</label>
                        <input type="file" name="foto_kegiatan" class="form-control">
                        @if (optional($logbooks->firstWhere('minggu', $i))->foto_kegiatan)
                            <img src="{{ asset('storage/' . optional($logbooks->firstWhere('minggu', $i))->foto_kegiatan) }}" alt="Foto Kegiatan" class="mt-2" width="100">
                        @endif
                    </div>

                    <div class="row">
                        @for ($j = 1; $j <= 5; $j++)
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Anggota {{ $j }}</label>
                                <input type="text" name="anggota{{ $j }}" class="form-control" value="{{ old('anggota'.$j, optional($logbooks->firstWhere('minggu', $i))->{'anggota'.$j}) }}">
                            </div>
                        @endfor
                    </div>

                    <input type="hidden" name="minggu" value="{{ $i }}">

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Simpan Logbook</button>
                    </div>
                </form>
            </div>
        </div>
    @endfor
</div>

@endsection
