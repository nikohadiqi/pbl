@extends('layouts.login-template')

@section('title', 'Register | Sistem Informasi dan Monitoring Project Based Learning')

@section('main-content')
<section>
    <div class="page-header min-vh-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-left">
                            <h4 class="font-weight-bolder">Pendaftaran Tim PBL</h4>
                            <p class="mb-0 text-sm">
                                Masukan data yang diperlukan untuk pendaftaran tim dan tunggu akun divalidasi oleh
                                Manajer Proyek untuk Login.
                            </p>
                        </div>
                        <div class="card-body pb-3">
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form method="POST" action="{{ route('register.tim') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="kelas">Kelas</label>
                                        <select name="kelas" id="kelas" class="form-control" required>
                                            <option value="" disabled {{ old('kelas') ? '' : 'selected' }} hidden>Pilih
                                                Kelas</option>
                                            @foreach ($kelas as $item)
                                            <option value="{{ $item->kelas }}" {{ old('kelas')==$item->kelas ?
                                                'selected' : '' }}>
                                                {{ $item->kelas }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="kelompok">Kelompok</label>
                                        <input type="number" name="kelompok" class="form-control" min="1" max="10"
                                            placeholder="Contoh: 1" value="{{ old('kelompok') }}" required>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="periode" class="form-control-label">Periode</label>
                                    <input type="hidden" name="periode" value="{{ $periodeAktif->id }}">
                                    <input type="text" class="form-control"
                                        value="Semester {{ $periodeAktif->semester }} - {{ $periodeAktif->tahun }}"
                                        readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="manpro">Manajer Proyek</label>
                                    <input type="text" class="form-control" id="manpro_nama" value="" readonly>
                                    <input type="hidden" name="manpro" id="manpro_nip">
                                </div>

                                <label for="anggota">Anggota (NIM)</label>
                                <div id="anggota-container">
                                    <div class="mb-3 d-flex">
                                        <select name="anggota[]" class="form-select form-control anggota-select"
                                            required></select>
                                        <button type="button" class="btn btn-sm btn-success add-anggota ms-2"><i
                                                class="bi bi-plus-lg"></i></button>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-100 mt-4 mb-0">Daftar</button>
                                </div>
                            </form>
                        </div>

                        <div class="card-footer pt-0 px-sm-4 px-1">
                            <p class="mb-4 mx-auto">
                                Sudah Memiliki Akun?
                                <a href="{{ route('login') }}" class="text-primary font-weight-bold">Masuk Disini</a>
                            </p>
                        </div>
                    </div>
                </div>
                {{-- Side Picture --}}
                <div
                    class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                    <div class="position-relative bg-gradient-primary h-100 m-3 px-7 pt-5 border-radius-lg d-flex flex-column justify-content-start overflow-hidden"
                        style="
                            background-image: url('{{ url('assets/img/login-image.png') }}');
                            background-repeat: no-repeat;
                            background-position: center;
                            background-size: contain;
                            background-position: bottom center;
                        ">
                        <span class="mask bg-gradient-primary opacity-6"></span>
                        <h3 class="mt-5 text-white font-weight-bolder position-relative bold">Sistem Informasi dan
                            Monitoring</h2>
                            <h3 class="text-white font-weight-bolder position-relative bold">Project Based Learning</h2>
                                <p class="text-white position-relative">Program Studi Teknologi Rekayasa Perangkat Lunak
                                </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('css')
{{-- Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
    rel="stylesheet" />
<style>
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #dee2e6 !important;
        border-radius: 0.5rem !important;
        padding: 0.5rem 1rem !important;
        font-size: 0.875rem;
        height: auto !important;
        transition: all 0.2s ease-in-out;
        position: relative;
        z-index: 1050;
        /* agar dropdown tidak tertutup elemen lain */
    }

    /* Efek focus */
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #dfa02c !important;
        box-shadow: 0 0 0 2px rgba(247, 205, 7, 0.1);
        outline: none;
    }

    /* Dropdown dengan rounded full, selalu sama */
    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid #dfa02c !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 4px 10px rgba(247, 205, 7, 0.1);
        margin-top: 2px;
        /* beri sedikit jarak dari select */
        overflow: hidden;
    }

    /* Agar dropdown yang muncul di atas juga rounded */
    .select2-container--bootstrap-5.select2-container--above .select2-dropdown {
        margin-top: 0;
        margin-bottom: 2px;
    }

    /* Render teks dan panah */
    .select2-container--bootstrap-5 .select2-selection__rendered {
        line-height: 1.5 !important;
        padding-left: 0 !important;
    }

    .select2-container--bootstrap-5 .select2-selection__arrow {
        top: 50% !important;
        transform: translateY(-50%);
        right: 1rem;
        position: absolute;
    }
</style>
@endpush

@push('js')
<!-- jQuery (required by Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- AJAX --}}
<script>
    $(document).ready(function () {
        $('#kelas').on('change', function () {
            const kelas = $(this).val();
            const periodeId = $('input[name="periode"]').val();

            if (kelas) {
                $.ajax({
                    url: '/register/search/manpro',
                    method: 'GET',
                    data: { kelas: kelas, periode_id: periodeId },
                    success: function (res) {
                        if (res && res.nip && res.nama) {
                            $('#manpro_nama').val(res.nama + ' (' + res.nip + ')');
                            $('#manpro_nip').val(res.nip);
                        } else {
                            $('#manpro_nama').val('Tidak ditemukan');
                            $('#manpro_nip').val('');
                        }
                    },
                    error: function () {
                        $('#manpro_nama').val('Manpro kelas ini belum ada.');
                        $('#manpro_nip').val('');
                    }
                });
            } else {
                $('#manpro_nama').val('');
                $('#manpro_nip').val('');
            }
        });

        // Anggota
        $('#kelas').on('change', function () {
            const kelas = $(this).val();

            // Reset anggota
            $('#anggota-container').html(`
                <div class="mb-3 d-flex">
                    <select name="anggota[]" class="form-select form-control anggota-select" required></select>
                    <button type="button" class="btn btn-sm btn-success add-anggota ms-2"><i class="bi bi-plus-lg"></i></button>
                </div>
            `);

            initSelect2Anggota('select[name="anggota[]"]', kelas);
        });

        function initSelect2Anggota(element, kelas) {
            $(element).select2({
                theme: 'bootstrap-5',
                placeholder: 'Cari NIM Mahasiswa',
                ajax: {
                    url: '/register/search/mahasiswa',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            kelas: kelas
                        };
                    },
                    processResults: function (data) {
                        return { results: data };
                    }
                }
            });
        }

        // Tambahkan anggota baru
        $('#anggota-container').on('click', '.add-anggota', function () {
            const kelas = $('#kelas').val();
            const jumlahAnggota = $('#anggota-container select[name="anggota[]"]').length;

            if (jumlahAnggota >= 7) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Batas Maksimal Terpenuhi',
                    text: 'Maksimal 7 anggota per tim!',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: true,
                    confirmButtonColor: '#dfa02c',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            const inputGroup = $(`
                <div class="mb-3 d-flex">
                    <select name="anggota[]" class="form-control anggota-select" required></select>
                    <button type="button" class="btn btn-sm btn-danger remove-anggota ms-2"><i class="bi bi-trash-fill"></i></button>
                </div>
            `);
            $('#anggota-container').append(inputGroup);
            initSelect2Anggota(inputGroup.find('select'), kelas);
        });

        // Hapus anggota
        $('#anggota-container').on('click', '.remove-anggota', function () {
            $(this).parent().remove();
        });
    });
</script>
@endpush
