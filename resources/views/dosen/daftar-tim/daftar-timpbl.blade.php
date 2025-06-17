@extends('layouts.dashboarddosen-template')

@section('title','Daftar Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Daftar Tim PBL')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4 shadow-sm rounded-3" style="background-color: #fff;">
        {{-- FORM FILTER --}}
        <form method="GET" action="{{ route('dosen.daftar-tim') }}" class="mb-4">
            <div class="row">
                {{-- SEMESTER --}}
                <div class="col-md-4 mb-2">
                    <select name="semester" class="form-select" onchange="this.form.submit()" required>
                        <option value="" hidden>-- Pilih Semester --</option>
                        @foreach ($semesterList as $smt)
                        <option value="{{ $smt }}" {{ $selectedSemester==$smt ? 'selected' : '' }}>
                            Semester {{ $smt }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- KELAS --}}
                <div class="col-md-4 mb-2">
                    <select name="kelas" class="form-select" onchange="this.form.submit()" required>
                        <option value="" hidden>-- Pilih Kelas --</option>
                        @foreach ($filteredKelas as $k)
                        <option value="{{ $k->kelas }}" {{ $selectedKelas==$k->kelas ? 'selected' : '' }}>
                            {{ $k->kelas }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- PERIODE AKTIF --}}
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control bg-light"
                        value="Semester {{ $periodeAktif->kategori_semester }} - {{ $periodeAktif->tahun }}" readonly>
                    <input type="hidden" name="tahun" value="{{ $periodeAktif->id }}">
                </div>
            </div>
            <hr class="horizontal dark mt-3">
        </form>

        {{-- Card Tim PBL --}}
        @forelse ($timPBL as $tim)
        @include('dosen.daftar-tim.partial.card-tim-pbl', ['tim' => $tim])
        @empty
        <div class="alert alert-info">Belum ada data tim sesuai filter.</div>
        @endforelse
    </div>
</div>
@endsection
