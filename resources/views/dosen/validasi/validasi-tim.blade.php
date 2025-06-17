@extends('layouts.dashboarddosen-template')

@section('title','Validasi Tim PBL | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Validasi Tim PBL')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Validasi Tim PBL Yang Diampu</h4>
            <a href="{{ route('dosen.validasi-tim.riwayat-tim-pbl') }}">
                <button class="btn btn-primary text-white fw-bold"><i class="bi bi-journal-bookmark"></i> Riwayat Tim
                    PBL Yang Diampu</button>
            </a>
        </div>
        <p class="text-sm">Berikut daftar seluruh tim yang diampu oleh Anda sebagai Manajer Proyek pada periode aktif.
        </p>

        <div class="table-responsive mt-2">
            <table class="table table-hover" id="datatable-basic">
                <thead class="table-light">
                    <tr>
                        <th>Kode Tim</th>
                        <th>Anggota</th>
                        <th>Manpro</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($timPBL as $tim)
                    <tr>
                        <td>{{ $tim->kode_tim }}</td>
                        <td class="text-wrap">
                            <ul class="mb-0 ps-3">
                                @foreach ($tim->anggota as $anggota)
                                <li>{{ $anggota->nim }} - {{ $anggota->mahasiswaFK->nama ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $tim->manproFK->nama }}</td>
                        <td>Semester {{ $tim->periodeFK->kategori_semester }}<br>Tahun {{ $tim->periodeFK->tahun }}</td>
                        <td>
                            @if ($tim->status === 'approved')
                            <span class="badge bg-gradient-success">Disetujui</span>
                            @elseif ($tim->status === 'rejected')
                            <span class="badge bg-gradient-danger">Ditolak</span>
                            @if($tim->alasan_reject)
                            <br>
                            <div class="text-danger text-sm text-wrap mt-2">Alasan:<br>{{ $tim->alasan_reject }}</div>
                            @endif
                            @else
                            <span class="badge bg-gradient-warning">Menunggu</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{-- Tombol Validasi / Tolak --}}
                            @if ($tim->status == 'pending')
                            <div class="d-flex flex-column align-items-center gap-1">
                                <form id="approve-form-{{ $tim->kode_tim }}"
                                    action="{{ route('dosen.validasi-tim.approve', $tim->kode_tim) }}" method="POST">
                                    @csrf
                                    <button type="button" class="btn btn-success btn-sm"
                                        onclick="confirmApprove('{{ $tim->kode_tim }}')">
                                        Validasi
                                    </button>
                                </form>

                                <form id="reject-form-{{ $tim->kode_tim }}"
                                    action="{{ route('dosen.validasi-tim.reject', $tim->kode_tim) }}" method="POST">
                                    @csrf
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmReject('{{ $tim->kode_tim }}')">
                                        Tolak
                                    </button>
                                </form>
                            </div>

                            @elseif ($tim->status == 'approved')
                            <div class="d-flex flex-column align-items-center gap-1">
                                <button class="btn btn-secondary btn-sm" disabled>Divalidasi</button>
                                {{-- Tombol Kelola Tim --}}
                                <a href="{{ route('dosen.validasi-tim.kelola', $tim->kode_tim) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="bi bi-person-gear"></i> Kelola Tim
                                </a>
                            </div>
                            @elseif ($tim->status == 'rejected')
                            <div class="d-flex flex-column align-items-center gap-1">
                                <button class="btn btn-dark btn-sm" disabled>Ditolak</button>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada tim yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function confirmApprove(kodeTim) {
        Swal.fire({
            title: 'Validasi Tim: ' + kodeTim,
            html: `
                <p>Untuk memvalidasi tim ini, ketik <strong>"validasi"</strong> pada form berikut:</p>
                <input type="text" id="confirmInput" class="swal2-input" placeholder="Ketik: validasi">
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Validasi',
            preConfirm: () => {
                const input = Swal.getPopup().querySelector('#confirmInput').value;
                if (input.toLowerCase() !== 'validasi') {
                    Swal.showValidationMessage('Ketik "validasi" untuk mengkonfirmasi.');
                }
                return true;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('approve-form-' + kodeTim).submit();
            }
        });
    }

    function confirmReject(kodeTim) {
    Swal.fire({
        title: 'Tolak Tim?',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan',
        inputPlaceholder: 'Tulis alasan penolakan tim ini...',
        inputAttributes: {
            'aria-label': 'Alasan penolakan'
        },
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Tolak!',
        preConfirm: (alasan) => {
            if (!alasan) {
                Swal.showValidationMessage('Alasan penolakan wajib diisi');
            }
            return alasan;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('reject-form-' + kodeTim);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'alasan_reject';
            input.value = result.value;

            form.appendChild(input);
            form.submit();
        }
    });
}
</script>
@endpush
