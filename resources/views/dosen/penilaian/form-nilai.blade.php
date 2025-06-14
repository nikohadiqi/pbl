@extends('layouts.dashboarddosen-template')

@section('title','Rubrik Penilaian Mahasiswa')
@section('page-title', 'Rubrik Penilaian')
@section('page-title-1', 'Penilaian Mahasiswa')
@section('page-title-1-url', route('dosen.penilaian'))

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-white">
            <div class="row">
                {{-- Kolom 1: Informasi Mahasiswa --}}
                <div class="col-md-6">
                    <h4 class="mb-2">Rubrik Penilaian Mahasiswa</h4>
                    <small class="text-muted">Mahasiswa: <strong>{{ $mahasiswa->nama }} (NIM. {{ $mahasiswa->nim
                            }})</strong></small><br>
                    <small class="text-muted">Mata Kuliah: <strong>{{ $pengampu->matkulFK->matakuliah
                            }}</strong></small><br>
                    <small class="text-muted">Status Dosen Penilai: <strong class="text-primary">{{ $pengampu->status ??
                            '-' }}</strong></small>
                </div>

                {{-- Kolom 2: Skala Penilaian --}}
                <div class="col-md-6 border-start">
                    <h6 class="text-muted mb-1 ms-3">Skala Penilaian:</h6>
                    <ul class="mb-0 ps-3 ms-3">
                        <li><strong>1</strong> : Kurang</li>
                        <li><strong>2</strong> : Cukup</li>
                        <li><strong>3</strong> : Baik</li>
                        <li><strong>4</strong> : Baik Sekali</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            @php
            $status = $pengampu->status ?? null;
            $isManajer = $status === 'Manajer Proyek';
            $isDosenMatkul = $status === 'Dosen Mata Kuliah';
            @endphp

            @if($isManajer || $isDosenMatkul)
            <form method="POST" action="{{ route('dosen.penilaian.simpan-nilai', $mahasiswa->nim) }}" id="rubrikForm">
                @csrf

                <table
                    class="table align-middle table-bordered border border-light shadow-sm rounded-3 overflow-hidden text-center">
                    <thead class="text-sm fw-semibold text-white bg-primary">
                        <tr>
                            <th>Aspek Penilaian</th>
                            <th>Bobot (%)</th>
                            <th>Nilai (1-4)</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Bagian Soft Skill --}}
                        <tr>
                            <td colspan="4"
                                class="bg-light fw-bold text-start text-dark ps-3 border border-light rounded-1">Nilai
                                Manajer Proyek
                            </td>
                        </tr>

                        @foreach($aspekSoftSkill as $index => $namaAspek)
                        @php
                        $slug = Str::slug($namaAspek, '_');
                        @endphp
                        <tr>
                            <td class="text-start ps-3">{{ $namaAspek }}</td>
                            <td><span class="text-primary">{{ $bobot[$namaAspek] }}%</span></td>
                            <td>
                                @if($isManajer)
                                @for($nilai = 1; $nilai <= 4; $nilai++) <label
                                    class="me-4 d-inline-flex align-items-center" style="font-size: 0.9rem;">
                                    <input type="radio" name="nilai_{{ $slug }}" value="{{ $nilai }}"
                                        onclick="hitungTotal()" style="transform: scale(1.25); margin-right: 4px;" {{
                                        old("nilai_$slug", $nilaiAspekGabungan[$namaAspek] ?? null)==$nilai ? 'checked'
                                        : '' }} required>
                                    {{ $nilai }}
                                    </label>
                                    @endfor
                                    @elseif($isDosenMatkul)
                                    <strong>{{ $nilaiAspekGabungan[$namaAspek] ?? '-' }}</strong>
                                    <input type="hidden" name="nilai_{{ $slug }}"
                                        value="{{ $nilaiAspekGabungan[$namaAspek] ?? 0 }}">
                                    @endif
                            </td>
                        </tr>
                        @endforeach

                        {{-- Bagian Akademik --}}
                        <tr>
                            <td colspan="4"
                                class="bg-light fw-bold text-start text-dark ps-3 border border-light rounded-1">Nilai
                                Dosen Mata Kuliah</td>
                        </tr>

                        @foreach($aspekAkademik as $index => $namaAspek)
                        @php
                        $slug = Str::slug($namaAspek, '_');
                        @endphp
                        <tr>
                            <td class="text-start ps-3">{{ $namaAspek }}</td>
                            <td><span class="text-primary">{{ $bobot[$namaAspek] }}%</span></td>
                            <td>
                                @if($isManajer)
                                    @for($nilai = 1; $nilai <= 4; $nilai++) <label
                                        class="me-4 d-inline-flex align-items-center" style="font-size: 0.9rem;">
                                        <input type="radio" name="nilai_{{ $slug }}" value="{{ $nilai }}"
                                            onclick="hitungTotal()" style="transform: scale(1.25); margin-right: 4px;" {{
                                            old("nilai_$slug", $nilaiAspekGabungan[$namaAspek] ?? null)==$nilai ? 'checked'
                                            : '' }} required>
                                        {{ $nilai }}
                                        </label>
                                    @endfor
                                @elseif($isDosenMatkul)
                                    @for($nilai = 1; $nilai <= 4; $nilai++) <label
                                        class="me-4 d-inline-flex align-items-center" style="font-size: 0.9rem;">
                                        <input type="radio" name="nilai_{{ $slug }}" value="{{ $nilai }}"
                                            onclick="hitungTotal()" style="transform: scale(1.25); margin-right: 4px;"
                                            {{ old("nilai_$slug", $nilaiDosenMatkul[$namaAspek] ?? null)==$nilai
                                            ? 'checked' : '' }} required>
                                        {{ $nilai }}
                                        </label>
                                    @endfor
                                 @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Ringkasan Nilai --}}
                <div class="card mt-2 border border-light shadow-sm rounded-3 overflow-hidden">
                    <div class="card-body bg-light">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <p class="fw-bold text-dark mb-1">Total Bobot</p>
                                <h5 class="text-warning">{{ array_sum($bobot) }}%</h5>
                            </div>
                            <div class="col-md-3">
                                <p class="fw-bold text-dark mb-1">Total Nilai (0-4)</p>
                                <h5 id="totalNilai" class="text-danger">0</h5>
                            </div>
                            <div class="col-md-3">
                                <p class="fw-bold text-dark mb-1">Angka Nilai</p>
                                <h5 id="angkaNilai" class="text-success">0</h5>
                            </div>
                            <div class="col-md-3">
                                <p class="fw-bold text-dark mb-1">Huruf Nilai</p>
                                <h5 id="hurufNilai" class="text-primary">-</h5>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Button --}}
                <div class="mt-5 text-end">
                    <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-floppy me-1"></i> Simpan
                        Nilai</button>
                </div>
            </form>
            @else
            <div class="alert alert-warning">Status pengampu <strong>{{ $status }}</strong> tidak dapat melakukan
                penilaian.</div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const aspekSoftSkill = @json($aspekSoftSkillSlug);
    const aspekAkademik = @json($aspekAkademikSlug);
    const bobot = @json($bobot);

    const konversiHuruf = (nilai) => {
        if (nilai >= 81) return 'A';
        if (nilai >= 76) return 'AB';
        if (nilai >= 66) return 'B';
        if (nilai >= 61) return 'BC';
        if (nilai >= 56) return 'C';
        if (nilai >= 41) return 'D';
        return 'E';
    }

    function hitungTotal() {
    let total = 0;
    let totalBobot = 0;

    [...Object.entries(aspekSoftSkill), ...Object.entries(aspekAkademik)].forEach(([label, slug]) => {
        const elems = document.getElementsByName(`nilai_${slug}`);
        let nilai = 0;
        for (const el of elems) {
            if (el.type === 'radio' && el.checked) {
                nilai = parseInt(el.value);
                break;
            }
            if (el.type === 'hidden') {
                nilai = parseInt(el.value);
            }
        }

        const persen = bobot[label] ?? 0;
        total += nilai * persen;
        totalBobot += persen;
    });

    const nilaiAkhir = totalBobot ? (total / totalBobot) : 0;
    const angka = nilaiAkhir * 25;
    const huruf = konversiHuruf(angka);

    document.getElementById('totalNilai').textContent = nilaiAkhir.toFixed(2);
    document.getElementById('angkaNilai').textContent = angka.toFixed(2);
    document.getElementById('hurufNilai').textContent = huruf;
    }

    document.addEventListener('DOMContentLoaded', function () {
        hitungTotal();
    });
</script>
@endpush
