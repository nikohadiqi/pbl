<div class="card mb-3 border rounded-3">
    <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
        <div style="flex: 1">
            <p class="mb-1"><strong>Nomor ID:</strong> {{ $tim->kode_tim }}</p>
            <h5 class="mb-1"><strong>{{ $tim->rencanaProyek->judul ?? 'Judul Belum Diisi' }}</strong></h5>
            <p class="mb-1">Manajer Proyek: {{ $tim->manproFK->nama ?? '-' }}</p>
            <p class="mb-2">Tim:</p>
            <ul class="mb-3">
                @forelse ($tim->anggota as $anggota)
                    <li>{{ $anggota->mahasiswaFK->nama ?? $anggota->nim }}</li>
                @empty
                    <li>Belum ada anggota</li>
                @endforelse
            </ul>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('dosen.daftar-tim.logbook', ['kode_tim' => $tim->kode_tim]) }}" class="btn btn-dark btn-sm">Lihat Logbook</a>
                <a href="{{ route('dosen.daftar-tim.laporan', ['kode_tim' => $tim->kode_tim]) }}" class="btn btn-dark btn-sm">Lihat Laporan</a>
                <a href="{{ route('dosen.daftar-tim.penilaian', ['kode_tim' => $tim->kode_tim]) }}" class="btn btn-dark btn-sm">Penilaian Mahasiswa</a>
            </div>
        </div>
        <div class="text-center mt-3 mt-md-0" style="width: 150px;">
            <div class="position-relative">
                <svg width="120" height="120">
                    <circle cx="60" cy="60" r="50" stroke="#eee" stroke-width="10" fill="none" />
                    <circle cx="60" cy="60" r="50" stroke="#000" stroke-width="10" fill="none"
                        stroke-dasharray="{{ 2 * 3.14 * 50 }}"
                        stroke-dashoffset="{{ 2 * 3.14 * 50 * (1 - $tim->progress_percent / 100) }}"
                        stroke-linecap="round" transform="rotate(-90 60 60)" />
                </svg>
                <div class="position-absolute top-50 start-50 translate-middle text-center">
                    <strong style="font-size: 1.5rem;">{{ $tim->progress_percent }}%</strong><br><small>Progres</small>
                </div>
            </div>
        </div>
    </div>
</div>
