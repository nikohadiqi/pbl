@extends('layouts.dashboardmahasiswa-template')

@section('title','Logbook Mingguan | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Logbook Mingguan')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Logbook Minggu ke-</h5>
        </div>
        <p class="text-sm">Sistem Informasi dan Monitoring Project Based Learning - TRPL Poliwangi</p>
        {{-- Menampilkan pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Tahapan --}}
        <div class="border border-1 rounded-3 p-3 shadow-sm bg-white mb-3">
            <form action="" method="POST">
                @csrf
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text fw-bold" id="inputGroup-sizing-sm">Nama Tahapan</span>
                        <input type="text" class="form-control"
                            value=" Mengidentifikasi fitur tambahan yang akan dikembangkan dalam waktu pelaksanaan proyek"
                            readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text fw-bold" id="inputGroup-sizing-sm">Person in Charge</span>
                        <input type="text" class="form-control" value="Ketua Tim">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text fw-bold" id="inputGroup-sizing-sm">Keterangan</span>
                        <input type="text" class="form-control" value="Keterangan 1">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>

        {{-- Form Logbook --}}
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label fw-semibold">Aktivitas</label>
                <input type="text" name="aktivitas" class="form-control"
                    placeholder="Aktivitas yang dilakukan minggu ini.." required>
            </div>

            <div class="form-group">
                <label class="form-label fw-semibold">Hasil (Link Drive Kegiatan, Design atau lainnya)</label>
                <input type="text" name="hasil" class="form-control"
                    placeholder="Sebutkan Output yang dicapai minggu ini.." required>
            </div>

            <div class="form-group">
                <label class="form-label fw-semibold">Foto Kegiatan</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label fw-semibold">Kontribusi Tim</label>
                <div id="kontribusi-container">
                    <div class="input-group mb-3">
                        <input type="text" name="kontribusi[]" class="form-control" placeholder="Nama : Mahasiswa 1" aria-label="Example text with button addon" aria-describedby="button-addon1">
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="tambahKontribusi()">+ Tambah Kontribusi Mahasiswa</button>
            </div>

            <div class="form-group">
                <label class="form-label fw-semibold">Progres Proyek</label>
                <input type="range" class="form-range" name="progress" min="0" max="100" value="0" id="progressRange">
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    function tambahKontribusi() {
        const container = document.getElementById('kontribusi-container');

        const div = document.createElement('div');
        div.className = 'input-group mb-2';

        const count = container.children.length + 1;
        div.setAttribute('data-index', count);

        div.innerHTML = `
            <input type="text" name="kontribusi[]" class="form-control" placeholder="Nama : Mahasiswa ${count}" aria-label="Example text with button addon" aria-describedby="button-addon1">
            <button class="btn btn-outline-danger mb-0" type="button" id="button-addon1" onclick="hapusBaris(this)">Hapus</button>
        `;

        container.appendChild(div);
    }

    function hapusBaris(button) {
        const row = button.parentNode;
        const index = row.getAttribute('data-index');

        if (index === "1") {
            alert("Baris pertama tidak dapat dihapus!");
            return;
        }

        row.remove();
        resetIndex();
    }

    function resetIndex() {
        const container = document.getElementById('kontribusi-container');
        const rows = container.querySelectorAll('.input-group');

        rows.forEach((row, i) => {
            const index = i + 1;
            row.setAttribute('data-index', index);
            row.querySelector('input').placeholder = `Nama : Mahasiswa ${index}`;

            const button = row.querySelector('button');
            if (button) {
                if (index === 1) {
                    button.remove(); // hilangkan tombol hapus dari baris pertama
                }
            } else if (index !== 1) {
                // kalau tombol hapus tidak ada dan bukan baris pertama, tambahkan
                const delBtn = document.createElement('button');
                delBtn.type = 'button';
                delBtn.className = 'btn btn-outline-danger btn-sm';
                delBtn.textContent = 'Hapus';
                delBtn.setAttribute('onclick', 'hapusBaris(this)');
                row.appendChild(delBtn);
            }
        });
    }
</script>
@endpush
