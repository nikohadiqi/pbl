@extends('layouts.dashboarddosen-template')

@section('title','Rubrik Penilaian Mahasiswa')
@section('page-title', 'Rubrik Penilaian')
@section('page-title-1', 'Penilaian Mahasiswa')
@section('page-title-1-url', route('dosen.penilaian'))

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-white">
            <h4 class="mb-2">Rubrik Penilaian Mahasiswa</h4>
            <small class="text-muted">Mahasiswa: <strong>{{ $mahasiswa->nama }} (NIM. {{ $mahasiswa->nim
                    }})</strong></small><br>
            <small class="text-muted">Mata Kuliah: <strong>{{ $pengampu->matkulFK->matakuliah }}</strong></small><br>
            <small class="text-muted">Status Dosen Penilai: <strong class="text-primary">{{ $pengampu->status ?? '-'
                    }}</strong></small>
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
                            <th>Metode Asesmen</th>
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
                        @php
                        $kelompok1Soft = ['critical_thinking', 'kolaborasi', 'kreativitas', 'komunikasi'];
                        $kelompok2Soft = ['fleksibilitas', 'kepemimpinan', 'produktifitas', 'social_skill'];
                        @endphp

                        @foreach($aspekSoftSkill as $index => $namaAspek)
                        <tr>
                            {{-- Label untuk kelompok 1 --}}
                            @if($index === 0)
                            <td class="align-middle" rowspan="{{ count($kelompok1Soft) }}">
                                <span>
                                    Observasi<br>
                                    <small><i>Learning Skills (20%)</i></small>
                                </span>
                            </td>
                            {{-- Label untuk kelompok 2 --}}
                            @elseif($index === count($kelompok1Soft))
                            <td class="align-middle" rowspan="{{ count($kelompok2Soft) }}">
                                <span>
                                    Produktivitas Kinerja<br>
                                    <small><i>Life Skills (20%)</i></small>
                                </span>
                            </td>
                            @endif

                            <td class="text-start ps-3">{{ ucwords(str_replace('_', ' ', $namaAspek)) }}</td>
                            <td><span class="text-primary">{{ $bobot[$namaAspek] }}%</span></td>
                            <td>
                                @if($isManajer)
                                @for($nilai = 1; $nilai <= 4; $nilai++) <label
                                    class="me-4 d-inline-flex align-items-center" style="font-size: 0.9rem;">
                                    <input type="radio" name="nilai_{{ $namaAspek }}" value="{{ $nilai }}"
                                        onclick="hitungTotal()" style="transform: scale(1.25); margin-right: 4px;" {{
                                        old("nilai_$namaAspek", $nilaiAspekGabungan[$namaAspek] ?? null)==$nilai
                                        ? 'checked' : '' }} required>
                                    {{ $nilai }}
                                    </label>
                                    @endfor
                                    @elseif($isDosenMatkul)
                                    <strong>{{ $nilaiAspekGabungan[$namaAspek] ?? '-' }}</strong>
                                    <input type="hidden" name="nilai_{{ $namaAspek }}"
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
                        @php
                        $kelompok1Akademik = ['konten_presentasi', 'tampilan_visual_presentasi', 'kosakata',
                        'tanya_jawab', 'mata_gerak_tubuh'];
                        $kelompok2Akademik = ['penulisan_laporan', 'pilihan_kata', 'konten_laporan'];
                        $kelompok3Akademik = ['sikap_kerja', 'proses', 'kualitas'];
                        @endphp

                        @foreach($aspekAkademik as $index => $namaAspek)
                        <tr>
                            {{-- Kelompok 1 --}}
                            @if($index === 0)
                            <td class="align-middle" rowspan="{{ count($kelompok1Akademik) }}">
                                <span>
                                    Presentasi<br>
                                    <small><i>(30%)</i></small>
                                </span>
                            </td>
                            {{-- Kelompok 2 --}}
                            @elseif($index === count($kelompok1Akademik))
                            <td class="align-middle" rowspan="{{ count($kelompok2Akademik) }}">
                                <span>
                                    Laporan<br>
                                    <small><i>(30%)</i></small>
                                </span>
                            </td>
                            {{-- Kelompok 3 --}}
                            @elseif($index === count($kelompok1Akademik) + count($kelompok2Akademik))
                            <td class="align-middle" rowspan="{{ count($kelompok3Akademik) }}">
                                <span>
                                    Proyek<br>
                                    <small><i>(30%)</i></small>
                                </span>
                            </td>
                            @endif

                            <td class="text-start ps-3">{{ ucwords(str_replace('_', ' ', $namaAspek)) }}</td>
                            <td><span class="text-primary">{{ $bobot[$namaAspek] }}%</span></td>
                            <td>
                                @if($isManajer)
                                @for($nilai = 1; $nilai <= 4; $nilai++) <label
                                    class="me-4 d-inline-flex align-items-center" style="font-size: 0.9rem;">
                                    <input type="radio" name="nilai_{{ $namaAspek }}" value="{{ $nilai }}"
                                        onclick="hitungTotal()" style="transform: scale(1.25); margin-right: 4px;" {{
                                        old("nilai_$namaAspek", $nilaiAspekGabungan[$namaAspek] ?? null)==$nilai
                                        ? 'checked' : '' }} required>
                                    {{ $nilai }}
                                    </label>
                                    @endfor
                                    @elseif($isDosenMatkul)
                                    <strong>{{ $nilaiAspekGabungan[$namaAspek] ?? '-' }}</strong>
                                    <input type="hidden" name="nilai_{{ $namaAspek }}"
                                        value="{{ $nilaiAspekGabungan[$namaAspek] ?? 0 }}">
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
    const aspekSoftSkill = @json($aspekSoftSkill);
    const aspekAkademik = @json($aspekAkademik);
    const bobot = @json($bobot);

    const konversiHuruf = (nilai) => {
        if (nilai >= 85) return 'A';
        if (nilai >= 80) return 'A-';
        if (nilai >= 75) return 'B+';
        if (nilai >= 70) return 'B';
        if (nilai >= 65) return 'B-';
        if (nilai >= 60) return 'C+';
        if (nilai >= 55) return 'C';
        if (nilai >= 50) return 'C-';
        if (nilai >= 40) return 'D';
        return 'E';
    };

    function hitungTotal() {
        let total = 0;
        let totalBobot = 0;

        [...aspekSoftSkill, ...aspekAkademik].forEach((aspek) => {
            const elems = document.getElementsByName(`nilai_${aspek}`);
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
            total += (bobot[aspek] || 0) * nilai;
            totalBobot += (bobot[aspek] || 0);
        });

        const skor = totalBobot > 0 ? total / totalBobot : 0;
        const angka = skor * 25;
        document.getElementById('totalNilai').innerText = skor.toFixed(2);
        document.getElementById('angkaNilai').innerText = angka.toFixed(2);
        document.getElementById('hurufNilai').innerText = konversiHuruf(angka);
    }

    document.addEventListener('DOMContentLoaded', hitungTotal);
</script>
@endpush
