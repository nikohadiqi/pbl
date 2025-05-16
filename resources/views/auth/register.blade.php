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
                                Manajer Proyek untuk Login
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

                            <form role="form" method="POST" action="{{ route('register.tim') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="kelas">Kelas</label>
                                        <input type="text" name="kelas" class="form-control" placeholder="Contoh: 2A" value="{{ old('kelas') }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="kelompok">Kelompok</label>
                                        <input type="number" name="kelompok" class="form-control" max="10" placeholder="Contoh: 1" value="{{ old('kelompok') }}" required>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="manpro" class="form-control-label">Manajer Proyek</label>
                                    <input id="manpro" class="form-control @error('manpro') is-invalid @enderror"
                                           name="manpro" placeholder="Masukkan NIP Manpro"
                                           type="number" required value="{{ old('manpro') }}">
                                    @error('manpro')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="periode" class="form-control-label">Periode</label>
                                    <select name="periode" class="form-control @error('periode') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('periode') ? '' : 'selected' }} hidden>Pilih Periode</option>
                                        <option value="Semester 4 - 2025" {{ old('periode') == 'Semester 4 - 2025' ? 'selected' : '' }}>Semester 4 - 2025</option>
                                        <option value="Semester 5 - 2025" {{ old('periode') == 'Semester 5 - 2025' ? 'selected' : '' }}>Semester 5 - 2025</option>
                                    </select>
                                    @error('periode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <label for="anggota">Anggota (NIM)</label>
                                <div id="anggota-container">
                                    <div class="mb-3 d-flex">
                                        <input type="text" name="anggota[]" class="form-control me-2"
                                            placeholder="Masukkan NIM Anggota" required>
                                        <button type="button" class="btn btn-sm btn-success add-anggota">+</button>
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

                <div
                    class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                    <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                        style="background-image: url('{{ asset('assets/img/login-image.png') }}'); background-size: unset;">
                        <span class="mask bg-gradient-primary opacity-6"></span>
                        <h4 class="mt-5 text-white font-weight-bolder position-relative bold">Sistem Informasi dan
                            Monitoring</h4>
                        <h4 class="text-white font-weight-bolder position-relative bold">Project Based Learning</h4>
                        <p class="text-white position-relative">Program Studi Teknologi Rekayasa Perangkat Lunak</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('anggota-container');
        document.querySelector('.add-anggota').addEventListener('click', function () {
            const inputGroup = document.createElement('div');
            inputGroup.classList.add('mb-3', 'd-flex');

            inputGroup.innerHTML = `
                <input type="text" name="anggota[]" class="form-control me-2" placeholder="Masukkan NIM Anggota" required>
                <button type="button" class="btn btn-sm btn-danger remove-anggota">-</button>
            `;

            container.appendChild(inputGroup);
        });

        container.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-anggota')) {
                e.target.parentElement.remove();
            }
        });
    });
</script>
@endpush
