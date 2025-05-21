@extends('layouts.dashboarddosen-template')

@section('title','Daftar Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Daftar Tim PBL')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4 shadow-sm rounded-3" style="background-color: #fff;">
        {{-- FORM FILTER --}}
        <div class="mb-3">
            <form method="GET" action="{{ route('dosen.daftar-tim') }}">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <select name="kelas" class="form-select">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $k)
                            <option value="{{ $k }}" {{ (old('kelas', $kelas ?? '' )==$k) ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <select name="tahun" class="form-select">
                            <option value="">-- Pilih Periode --</option>
                            @foreach($periodeList as $periode)
                            <option value="{{ $periode->id }}" {{ (old('tahun', $tahun ?? '' )==$periode->id) ? 'selected' : '' }}>
                                Semester {{ $periode->semester }} - {{ $periode->tahun }}
                            </option>
                            @endforeach
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
        @forelse ($timPBL as $tim)
        @include('dosen.daftar-tim.partial.card-tim-pbl', ['tim' => $tim])
        @empty
        <div class="alert alert-info">Belum ada data tim sesuai filter.</div>
        @endforelse
    </div>
</div>
@endsection
