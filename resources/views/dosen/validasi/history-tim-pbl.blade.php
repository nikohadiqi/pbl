@extends('layouts.dashboarddosen-template')

@section('title','Riwayat Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Riwayat Tim PBL Yang Pernah Diampu')
@section('page-title-1', 'Validasi Tim PBL')
@section('page-title-1-url', route('dosen.validasi-tim'))
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        {{-- Filter --}}
        <form method="GET" class="mb-3">
            <label for="periode_id" class="form-label">Pilih Periode Selesai</label>
            <div class="input-group">
                <select name="periode_id" id="periode_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Periode --</option>
                    @if(isset($periodes) && $periodes->count() > 0)
                    @foreach($periodes as $periode)
                    <option value="{{ $periode->id }}" {{ (isset($periodeId) && $periodeId==$periode->id) ?
                        'selected' : '' }}>
                        Semester {{ $periode->semester }} - Tahun {{ $periode->tahun }}
                    </option>
                    @endforeach
                    @else
                    <option disabled>Tidak ada periode selesai</option>
                    @endif
                </select>
            </div>
            <hr class="horizontal dark mt-4">
        </form>

        {{-- Isi --}}
        @if ($periodeId)
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Riwayat Tim PBL</h4>
        </div>
        <p class="text-sm">Berikut adalah daftar seluruh tim PBL yang telah Anda ampu pada periode yang telah selesai.
        </p>
        <div class="table-responsive">
            <table class="table table-hover" id="datatable-normal">
                <thead class="table-light">
                    <tr>
                        <th>Nomor</th>
                        <th>Kode Tim</th>
                        <th>Anggota</th>
                        <th>Periode</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($timPBL as $index => $tim)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $tim->kode_tim }}</td>
                        <td>
                            <ul class="mb-0 ps-3">
                                @foreach ($tim->anggota as $anggota)
                                <li>{{ $anggota->nim }} - {{ $anggota->mahasiswaFK->nama ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>Semester {{ $tim->periodeFK->kategori_semester }}<br>Tahun {{ $tim->periodeFK->tahun }}</td>
                        <td>
                            @if ($tim->status === 'approved')
                            <span class="badge bg-success">Disetujui</span>
                            @elseif ($tim->status === 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                            @else
                            <span class="badge bg-warning">Menunggu</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada riwayat tim pada periode yang telah selesai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif
        @unless ($periodeId)
        <div class="alert alert-info">
            Silakan pilih periode terlebih dahulu untuk melihat riwayat tim.
        </div>
        @endunless
    </div>
</div>
@endsection
