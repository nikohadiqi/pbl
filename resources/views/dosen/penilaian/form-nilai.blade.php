@extends('layouts.dashboarddosen-template')

@section('title','Penilaian Mahasiswa')
@section('page-title', 'Rubrik Penilaian')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <h4>Rubrik Penilaian</h4>
            <p>Nama Mahasiswa: <strong>{{ $mahasiswa->nama }}</strong></p>
        </div>
        <div class="card-body">

            {{-- Alert sukses --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Alert error --}}
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

            <form method="POST" action="{{ route('dosen.penilaian.beri-nilai', $mahasiswa->nim) }}" id="rubrikForm">
                @csrf
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-info">
                        <tr>
                            <th>Aspek Penilaian</th>
                            <th>Bobot</th>
                            <th>Nilai (1-4)</th>
                        </tr>
                    </thead>
                    <tbody id="rubrikTable">
                        @foreach($aspek as $index => $namaAspek)
                        <tr>
                            <td>{{ ucwords(str_replace('_', ' ', $namaAspek)) }}</td>
                            <td>
                                <input 
                                    type="number" 
                                    name="bobot[]" 
                                    class="form-control bobot" 
                                    min="0" max="100" step="0.1" 
                                    value="{{ old("bobot.$index", $bobot[$namaAspek] ?? 0) }}" 
                                    onchange="hitungTotal()" 
                                    readonly
                                >
                            </td>
                            <td>
                                @for($nilaiOpt = 1; $nilaiOpt <= 4; $nilaiOpt++)
                                <label class="me-2">
                                    <input 
                                        type="radio" 
                                        name="nilai{{ $index }}" 
                                        value="{{ $nilaiOpt }}" 
                                        onclick="hitungTotal()"
                                        {{ old("nilai$index", $nilaiAspek[$index] ?? null) == $nilaiOpt ? 'checked' : '' }}
                                    > {{ $nilaiOpt }}
                                </label>
                                @endfor
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="bg-info text-white p-3 mt-2">
                    <p><strong>Total Bobot:</strong> {{ array_sum($bobot) }}</p>
                    <p><strong>Total Nilai (0-4):</strong> <span id="totalNilai">0</span></p>
                    <p><strong>Angka Nilai:</strong> <span id="angkaNilai">0</span></p>
                    <p><strong>Huruf Nilai:</strong> <span id="hurufNilai">-</span></p>
                </div>

                <button type="submit" class="btn btn-primary fw-bold mt-2">Simpan Nilai</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function hitungTotal() {
        let totalNilai = 0;
        let totalBobot = 0;

        document.querySelectorAll("#rubrikTable tr").forEach((row, index) => {
            const bobot = parseFloat(row.querySelector(".bobot").value) || 0;
            const nilai = row.querySelector('input[name="nilai' + index + '"]:checked');
            const nilaiVal = nilai ? parseInt(nilai.value) : 0;
            totalNilai += bobot * nilaiVal;
            totalBobot += bobot;
        });

        const nilaiSkala = totalBobot ? (totalNilai / totalBobot) : 0;
        const angkaNilai = (nilaiSkala * 25).toFixed(2);
        document.getElementById("totalNilai").textContent = nilaiSkala.toFixed(2);
        document.getElementById("angkaNilai").textContent = angkaNilai;
        document.getElementById("hurufNilai").textContent = konversiHuruf(angkaNilai);
    }

    function konversiHuruf(nilai) {
        nilai = parseFloat(nilai);
        if (nilai >= 85) return "A";
        if (nilai >= 80) return "A-";
        if (nilai >= 75) return "B+";
        if (nilai >= 70) return "B";
        if (nilai >= 65) return "B-";
        if (nilai >= 60) return "C+";
        if (nilai >= 55) return "C";
        if (nilai >= 50) return "D";
        return "E";
    }

    // Hitung nilai langsung saat halaman dimuat
    window.addEventListener('load', hitungTotal);
</script>
@endpush
