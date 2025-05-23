@extends('layouts.dashboarddosen-template')

@section('title','Penilaian Mahasiswa')
@section('page-title', 'Rubrik Penilaian')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-white">
            <h4 class="mb-0">Rubrik Penilaian</h4>
            <small class="text-muted">Nama Mahasiswa: <strong>{{ $mahasiswa->nama }}</strong></small><br>
            <small class="text-muted">Status Pengampu:
                <strong class="text-primary">{{ $pengampu->status ?? '-' }}</strong>
            </small>
        </div>
        <div class="card-body">

            {{-- Alert --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $status = $pengampu->status ?? null;
                $isManajer = $status === 'Manajer Proyek';
                $aspekAktif = $isManajer ? $aspekSoftSkill : $aspekAkademik;
            @endphp

            @if(in_array($status, ['Manajer Proyek', 'Dosen Mata Kuliah']))
                <form method="POST" action="{{ route('dosen.penilaian.beri-nilai', $mahasiswa->nim) }}" id="rubrikForm">
                    @csrf
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-warning text-dark">
                            <tr>
                                <th>Aspek Penilaian</th>
                                <th>Bobot (%)</th>
                                <th>Nilai (1-4)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aspekAktif as $index => $namaAspek)
                                <tr>
                                    <td class="bg-white text-dark">{{ ucwords(str_replace('_', ' ', $namaAspek)) }}</td>
                                    <td class="bg-white text-warning fw-semibold">
                                        <input
                                            type="number"
                                            class="form-control form-control-sm bobot text-center fw-bold text-warning border-warning"
                                            value="{{ $bobot[$namaAspek] }}"
                                            readonly
                                        >
                                    </td>
                                    <td class="bg-white">
                                       @for($nilaiOpt = 1; $nilaiOpt <= 4; $nilaiOpt++)
                    <label class="me-2">
                        <input
                            type="radio"
                            name="nilai{{ $index }}"
                            value="{{ $nilaiOpt }}"
                            onclick="hitungTotal()"
                            {{ old("nilai$index", $nilaiAspekGabungan[$namaAspek] ?? null) == $nilaiOpt ? 'checked' : '' }}
                            required
                        > {{ $nilaiOpt }}
                    </label>
                @endfor
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="card mt-4 border-0 shadow-sm">
                        <div class="card-body bg-light">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <p class="fw-bold text-dark mb-1">Total Bobot</p>
                                    <h5 class="text-warning">{{ array_sum($bobot) }}%</h5>
                                </div>
                                <div class="col-md-3">
                                    <p class="fw-bold text-dark mb-1">Total Nilai (0-4)</p>
                                    <h5 id="totalNilai" class="text-primary">0</h5>
                                </div>
                                <div class="col-md-3">
                                    <p class="fw-bold text-dark mb-1">Angka Nilai</p>
                                    <h5 id="angkaNilai" class="text-success">0</h5>
                                </div>
                                <div class="col-md-3">
                                    <p class="fw-bold text-dark mb-1">Huruf Nilai</p>
                                    <h5 id="hurufNilai" class="text-danger">-</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Nilai</button>
                    </div>
                </form>
            @else
                <div class="alert alert-warning">
                    Status pengampu <strong>{{ $status }}</strong> tidak dapat melakukan penilaian.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Script --}}
<script>
    const aspek = @json($aspekAktif);
    const bobot = @json($bobot);
    const konversiHuruf = (nilai) => {
        if (nilai >= 85) return 'A';
        if (nilai >= 80) return 'A-';
        if (nilai >= 75) return 'B+';
        if (nilai >= 70) return 'B';
        if (nilai >= 65) return 'B-';
        if (nilai >= 60) return 'C+';
        if (nilai >= 55) return 'C';
        if (nilai >= 50) return 'D';
        return 'E';
    };

    function hitungTotal() {
        let total = 0;
        let totalBobot = 0;

        aspek.forEach((namaAspek, index) => {
            const nilaiElems = document.getElementsByName(`nilai${index}`);
            let nilaiTerpilih = 0;
            for (const elem of nilaiElems) {
                if (elem.checked) {
                    nilaiTerpilih = parseInt(elem.value);
                    break;
                }
            }
            const bobotValue = bobot[namaAspek] || 0;
            total += bobotValue * nilaiTerpilih;
            totalBobot += bobotValue;
        });

        const skorSkala = totalBobot > 0 ? total / totalBobot : 0;
        const angkaNilai = skorSkala * 25;
        const hurufNilai = konversiHuruf(angkaNilai);

        document.getElementById('totalNilai').innerText = skorSkala.toFixed(2);
        document.getElementById('angkaNilai').innerText = angkaNilai.toFixed(2);
        document.getElementById('hurufNilai').innerText = hurufNilai;
    }

    document.addEventListener('DOMContentLoaded', hitungTotal);
</script>
@endsection
