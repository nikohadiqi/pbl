@extends('layouts.dashboarddosen-template')

@section('title','Penilaian Mahasiswa')
@section('page-title', 'Penilaian Mahasiswa')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4 shadow-sm rounded-3">
        {{-- Filter Kelas --}}
        <form method="GET" action="{{ route('dosen.penilaian') }}" class="mb-3">
            <label for="kelas" class="form-label">Pilih Kelas</label>
            <div class="input-group">
                <select name="kelas" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $kelas)
                    <option value="{{ $kelas }}" {{ $selectedKelas==$kelas ? 'selected' : '' }}>
                        {{ $kelas }}
                    </option>
                    @endforeach
                </select>
            </div>
            <hr class="horizontal dark mt-4">
        </form>

        @if ($selectedKelas)
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">
                Penilaian Mahasiswa Kelas {{ $selectedKelas }}
            </h4>
            <!-- Ekspor -->
            <form action="{{ route('penilaian.export') }}" method="GET">
                <input type="hidden" name="kelas" value="{{ $selectedKelas }}">
                <button type="submit" class="btn btn-primary fw-bold mt-3"><i class="bi bi-file-earmark-excel"></i>
                    Ekspor Nilai Kelas</button>
            </form>
        </div>
        <!-- Tampilkan mata kuliah dari pengampu -->
        @foreach ($pengampu as $p)
        <p class="text-sm"><strong>Mata Kuliah :</strong> {{ $p->matkulFK->matakuliah ?? '-' }}</p>
        <p class="text-sm"><strong>Status Dosen :</strong> {{ $p->status }}</p>
        @endforeach
        <p class="text-sm"><strong>Jumlah Mahasiswa :</strong> {{ $mahasiswa->count() }}</p>
        @endif

        <div class="table-responsive">
            <table class="table table-hover" id="datatable-search">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Nilai</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $index => $mhs)
                    @php
                    $nilai = $nilaiMahasiswa->first(function ($n) use ($mhs, $pengampu) {
                    return $n->nim === $mhs->nim && $pengampu->contains('id', $n->pengampu_id);
                    });
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->nama }}</td>
                        <td>
                            @if($nilai)
                            @php
                            $angka = $nilai->angka_nilai;
                            $huruf = $nilai->huruf_nilai;

                            // Warna berdasarkan angka (opsional, bisa digabung dengan huruf)
                            $warnaAngka = $angka >= 76 ? 'text-success' :
                            ($angka >= 61 ? 'text-warning' : 'text-danger');

                            // Warna berdasarkan huruf nilai (lebih akurat sesuai konversiHuruf js)
                            $warnaHuruf = in_array($huruf, ['A', 'AB']) ? 'text-success' :
                            (in_array($huruf, ['B', 'BC']) ? 'text-warning' : 'text-danger');
                            @endphp

                            <span class="text-sm">Angka Nilai:
                                <strong class="{{ $warnaAngka }}">{{ number_format($angka, 2) }}</strong>
                            </span><br>
                            <span class="text-sm">Huruf Nilai:
                                <strong class="{{ $warnaHuruf }}">{{ $huruf }}</strong>
                            </span>
                            @else
                            <span class="text-muted">Belum Dinilai</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @php
                            $isDosenMatkul = $pengampu->first()?->status !== 'Manajer Proyek';

                            // Cek apakah manpro sudah menilai mahasiswa ini
                            $nilaiDariManpro = $nilaiManpro->firstWhere('nim', $mhs->nim);
                            @endphp

                            @if ($isDosenMatkul && !$nilaiDariManpro)
                            <button class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Menunggu penilaian dari Manajer Proyek" data-container="body" data-animation="true">
                                <i class="bi bi-lock"></i> Beri Nilai
                            </button>
                            @else
                            <a href="{{ route('dosen.penilaian.beri-nilai', $mhs->nim) }}"
                                class="btn btn-sm {{ $nilai ? 'btn-secondary' : 'btn-primary' }}">
                                <i class="bi {{ $nilai ? 'bi-pencil' : 'bi-pencil-square' }}"></i>
                                {{ $nilai ? 'Ubah Nilai' : 'Beri Nilai' }}
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Pilih kelas untuk melihat mahasiswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
