@extends('layouts.dashboardadmin-template')

@section('title', 'Tambah Tim PBL')

@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        <h5 class="fw-bold">Tambah Tim PBL</h5>
        <p class="text-sm">Tambahkan tim baru dalam sistem PBL</p>
        
        <form action="{{ route('admin.timpbl.store') }}" method="POST">
            @csrf

            <!-- ID Tim (Manual Input) -->
            <div class="form-group mb-3">
                <label for="id_tim">ID Tim</label>
                <input type="text" name="id_tim" class="form-control @error('id_tim') is-invalid @enderror" 
                       placeholder="Masukkan ID Tim" value="{{ old('id_tim') }}" required>
                @error('id_tim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Kode Tim -->
            <div class="form-group mb-3">
                <label for="kode_tim">Kode Tim</label>
                <input type="text" name="kode_tim" class="form-control @error('kode_tim') is-invalid @enderror" 
                       placeholder="Masukkan Kode Tim" value="{{ old('kode_tim') }}" required>
                @error('kode_tim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Ketua Tim (Search by NIM) -->
            <div class="form-group mb-3">
                <label for="ketua_nim">Ketua Tim</label>
                <div class="input-group">
                    <input type="text" class="form-control @error('ketua_nim') is-invalid @enderror" 
                           id="ketua_nim" name="ketua_nim" placeholder="Cari berdasarkan NIM..." required>
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
                <small class="text-muted" id="nama_ketua">Nama Ketua: -</small>
                @error('ketua_nim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="{{ route('admin.timpbl') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let ketuaInput = document.getElementById('ketua_nim');
    let namaKetua = document.getElementById('nama_ketua');

    ketuaInput.addEventListener('input', function() {
        let nim = this.value.trim();
        if (nim.length >= 5) {
            fetch(`{{ url('/admin/search-mahasiswa') }}?nim=${nim}`)
                .then(response => response.json())
                .then(data => {
                    namaKetua.textContent = data.nama ? `Nama Ketua: ${data.nama}` : "Mahasiswa tidak ditemukan.";
                })
                .catch(error => {
                    namaKetua.textContent = "Gagal mencari mahasiswa.";
                });
        } else {
            namaKetua.textContent = "Nama Ketua: -";
        }
    });
});
</script>
@endsection
