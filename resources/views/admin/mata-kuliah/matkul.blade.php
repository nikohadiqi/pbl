@extends('layouts.dashboardadmin-template')

@section('title','Mata Kuliah | Sistem Informasi dan Monitoring Project Based Learning')
@section('page-title', 'Mata Kuliah')
@section('content')
<div class="container-fluid py-4">
    <div class="card p-4">
        {{-- Filter --}}
        <form method="GET" action="{{ route('admin.matkul') }}" class="mb-3">
            <label for="periode_id" class="form-label">Pilih Periode</label>
            <div class="input-group">
                <select name="periode_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Periode --</option>
                    @foreach ($periodes as $periode)
                    <option value="{{ $periode->id }}" {{ $selectedPeriodeId == $periode->id ? 'selected' : '' }}>
                        Semester {{ $periode->semester }} - {{ $periode->tahun }}
                    </option>
                    @endforeach
                </select>
            </div>
            <hr class="horizontal dark mt-4">
        </form>

        @if ($selectedPeriodeId)
        <!-- Notifikasi -->
       @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Mata Kuliah PBL</h4>
        </div>
        <p class="text-sm">Daftar Mata Kuliah yang menjadi Mata Kuliah PBL periode ini.</p>

        {{-- FORM INPUT MATA KULIAH --}}
        <form method="POST" action="{{ route('admin.matkul.manage.store') }}">
            @csrf
            <input type="hidden" name="periode_id" value="{{ $selectedPeriodeId }}">

            <div class="table-responsive">
                <table class="table align-middle table-hover table-borderless border border-light shadow-sm rounded-3 overflow-hidden" id="matkul-table">
                    <thead class="text-sm fw-semibold text-white bg-primary">
                        <tr class="text-center">
                            <th>Kode Mata Kuliah</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Program Studi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mataKuliahList as $matkul)
                        <tr>
                            <td>
                                <input type="hidden" name="id[]" value="{{ $matkul->id }}">
                                <input type="text" name="kode[]" class="form-control kode-input" value="{{ $matkul->kode }}" required maxlength="8" minlength="8">
                                <small class="text-danger kode-error" style="display:none;">Kode harus 8 karakter</small>
                            </td>
                            <td><input type="text" name="matakuliah[]" class="form-control" value="{{ $matkul->matakuliah }}" required></td>
                            <td><input type="number" name="sks[]" min="1" max="10" class="form-control text-center" value="{{ $matkul->sks }}" required></td>
                            <td>
                                <input type="text" class="form-control" value="Teknologi Rekayasa Perangkat Lunak" readonly>
                                <input type="hidden" name="program_studi[]" value="Teknologi Rekayasa Perangkat Lunak">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm remove-row" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" data-container="body" data-animation="true"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td>
                                <input type="hidden" name="id[]" value="">
                                <input type="text" name="kode[]" class="form-control kode-input" required maxlength="8" minlength="8">
                                <small class="text-danger kode-error" style="display:none;">Kode harus 8 karakter</small>
                            </td>
                            <td><input type="text" name="matakuliah[]" class="form-control" required></td>
                            <td><input type="number" name="sks[]" min="1" max="10" class="form-control text-center" required></td>
                            <td>
                                <input type="text" class="form-control" value="Teknologi Rekayasa Perangkat Lunak" readonly>
                                <input type="hidden" name="program_studi[]" value="Teknologi Rekayasa Perangkat Lunak">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm remove-row" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" data-container="body" data-animation="true"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                <button type="button" class="btn btn-success btn-sm" id="add-row"><i class="bi bi-plus-circle"></i> Tambah Mata Kuliah</button>
                <button class="btn btn-primary mt-3 text-white fw-bold float-end" type="submit"><i class="bi bi-floppy me-1"></i> Simpan Semua</button>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection

@push('script')
<script>
    document.getElementById('add-row').addEventListener('click', function () {
        const tableBody = document.querySelector('#matkul-table tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <input type="hidden" name="id[]" value="">
                <input type="text" name="kode[]" class="form-control kode-input" required maxlength="8" minlength="8">
                <small class="text-danger kode-error" style="display:none;">Kode harus 8 karakter</small>
            </td>
            <td><input type="text" name="matakuliah[]" class="form-control" required></td>
            <td><input type="number" name="sks[]" min="1" max="10" class="form-control text-center" required></td>
            <td>
                <input type="text" class="form-control" value="Teknologi Rekayasa Perangkat Lunak" readonly>
                <input type="hidden" name="program_studi[]" value="Teknologi Rekayasa Perangkat Lunak">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-row" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" data-container="body" data-animation="true"><i class="bi bi-trash"></i></button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    // Hapus baris
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-row')) {
            const row = e.target.closest('tr');
            row.remove();
        }
    });

    // Validasi real-time panjang kode
    document.addEventListener('input', function (event) {
        if (event.target.classList.contains('kode-input')) {
            const input = event.target;
            const errorEl = input.nextElementSibling;
            if (input.value.length !== 8) {
                errorEl.style.display = 'block';
                input.classList.add('is-invalid');
            } else {
                errorEl.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        }
    });
</script>
@endpush
