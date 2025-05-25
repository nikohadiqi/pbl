@extends('layouts.dashboarddosen-template')

@section('title', 'Penilaian Mahasiswa')
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

            {{-- Alert Messages --}}
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
                $isDosen = $status === 'Dosen Mata Kuliah';

                $learningskill = ['critical_thinking', 'kolaborasi', 'kreativitas', 'komunikasi'];
                $lifeskills = ['fleksibilitas', 'kepemimpinan', 'produktifitas', 'social_skill'];
                $presentasi = ['konten', 'tampilan_visual_presentasi', 'kosakata', 'tanya_jawab', 'mata_gerak_tubuh'];
                $laporan = ['penulisan_laporan', 'pilihan_kata', 'konten_2'];
                $sikapketerampilan = ['sikap_kerja', 'proses', 'kualitas'];

                $semuaAspek = array_merge($learningskill, $lifeskills, $presentasi, $laporan, $sikapketerampilan);

                if ($isManajer) {
                    $aspekAktif = $semuaAspek;
                } elseif ($isDosen) {
                    $aspekAktif = array_merge($presentasi, $laporan, $sikapketerampilan);
                } else {
                    $aspekAktif = [];
                }

                $disabledAspekDosen = array_merge($learningskill, $lifeskills);

                // $nilaiAspekGabungan dan $bobot di-passing dari Controller
            @endphp

            @if(in_array($status, ['Manajer Proyek', 'Dosen Mata Kuliah']))
                <form method="POST" action="{{ route('dosen.penilaian.beri-nilai', $mahasiswa->nim) }}" id="rubrikForm" novalidate>
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
                            @foreach($aspekAktif as $namaAspek)
                                @php
                                    $isDisabled = $isDosen && in_array($namaAspek, $disabledAspekDosen);
                                    $nilaiLama = old('nilai.' . $namaAspek, $nilaiAspekGabungan[$namaAspek] ?? '');
                                @endphp
                                <tr>
                                    <td class="bg-white text-start text-dark">{{ ucwords(str_replace('_', ' ', $namaAspek)) }}</td>
                                    <td class="bg-white text-warning fw-semibold" style="width: 15%">
                                        <span class="fw-bold">{{ $bobot[$namaAspek] ?? 0 }}%</span>
                                    </td>
                                    <td class="bg-white text-center" style="width: 40%">
                                        @for($nilaiOpt = 1; $nilaiOpt <= 4; $nilaiOpt++)
                                            <div class="form-check form-check-inline">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    id="nilai_{{ $namaAspek }}_{{ $nilaiOpt }}"
                                                    name="nilai[{{ $namaAspek }}]"
                                                    value="{{ $nilaiOpt }}"
                                                    onclick="hitungTotal()"
                                                    {{ $nilaiLama == $nilaiOpt ? 'checked' : '' }}
                                                    {{ $isDisabled ? 'disabled' : '' }}
                                                    @if(!$isDisabled) required @endif
                                                >
                                                <label class="form-check-label" for="nilai_{{ $namaAspek }}_{{ $nilaiOpt }}">{{ $nilaiOpt }}</label>
                                            </div>
                                        @endfor
                                        @if($isDisabled)
                                            <input type="hidden" name="nilai[{{ $namaAspek }}]" value="{{ $nilaiLama }}">
                                        @endif
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
                                    <h5 class="text-warning">{{ array_sum($bobot) ?? 0 }}%</h5>
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

<script>
    const aspek = @json($aspekAktif);
    const bobot = @json($bobot);

    function konversiHuruf(nilai) {
        if (nilai >= 85) return 'A';
        if (nilai >= 80) return 'A-';
        if (nilai >= 75) return 'B+';
        if (nilai >= 70) return 'B';
        if (nilai >= 65) return 'B-';
        if (nilai >= 60) return 'C+';
        if (nilai >= 55) return 'C';
        if (nilai >= 50) return 'D';
        return 'E';
    }

    function hitungTotal() {
        let total = 0;
        let totalBobot = 0;

        aspek.forEach((namaAspek) => {
            const radios = document.getElementsByName(`nilai[${namaAspek}]`);
            let nilaiTerpilih = 0;

            for (const radio of radios) {
                if (radio.checked) {
                    nilaiTerpilih = parseInt(radio.value);
                    break;
                }
            }

            const bobotValue = bobot[namaAspek] ?? 0;
            total += bobotValue * nilaiTerpilih;
            totalBobot += bobotValue;
        });

        const skorSkala = totalBobot > 0 ? total / totalBobot : 0;
        const angkaNilai = skorSkala * 25;  // Skala 0-100, 1-4 jadi 0-100
        const hurufNilai = konversiHuruf(angkaNilai);

        document.getElementById('totalNilai').innerText = skorSkala.toFixed(2);
        document.getElementById('angkaNilai').innerText = angkaNilai.toFixed(2);
        document.getElementById('hurufNilai').innerText = hurufNilai;
    }

    window.onload = hitungTotal;
</script>
@endsection
