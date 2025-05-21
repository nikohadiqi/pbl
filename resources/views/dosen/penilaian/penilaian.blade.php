@extends('layouts.dashboarddosen-template')

@section('title','Penilaian Mahasiswa')
@section('page-title', 'Penilaian Mahasiswa')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4 shadow-sm rounded-3">
        <form method="GET" action="{{ route('dosen.penilaian') }}">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <select name="kelas" class="form-control">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="2A" {{ request('kelas') == '2A' ? 'selected' : '' }}>2A</option>
                        <option value="4B" {{ request('kelas') == '4B' ? 'selected' : '' }}>4B</option>
                        <option value="4C" {{ request('kelas') == '4C' ? 'selected' : '' }}>4C</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                </div>
            </div>
        </form>
        <hr>

        <p>Kelas terpilih: {{ $kelas }}</p>
        <p>Jumlah mahasiswa: {{ $mahasiswa->count() }}</p>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Kelas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $index => $mhs)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $mhs->nim }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->kelas }}</td>
                            <td class="text-center">
                                <a href="{{ route('dosen.penilaian.beri-nilai', $mhs->nim) }}" class="btn btn-sm btn-primary">
                                    Beri Nilai
                                </a>
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
