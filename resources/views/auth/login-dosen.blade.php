@extends('layouts.login-template')

@section('title','Login | Sistem Informasi dan Monitoring Project Based Learning')

@section('main-content')
<section>
    <div class="page-header min-vh-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-start">
                            <img src="{{ url('assets/img/login-logo.png') }}" alt="logo" width="50%" class="mb-3">
                            <h4 class="font-weight-bolder">Login Dosen / Admin</h4>
                            <p class="mb-0">Masukan NIP/NIK/NIPPPK dan Password untuk Login!</p>
                            @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form role="form" method="POST" action="{{ route('login.post') }}">
                                @csrf
                                <div class="mb-3 position-relative">
                                    <select id="role" name="role"
                                        class="form-control form-control-lg @error('role') is-invalid @enderror"
                                        required>
                                        <option value="" disabled selected>Pilih Jenis User</option>
                                        <option value="dosen" {{ old('role')=='dosen' ? 'selected' : '' }}>Dosen
                                        </option>
                                        <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin
                                        </option>
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input id="nim" type="text"
                                        class="form-control form-control-lg @error('nim') is-invalid @enderror"
                                        name="nim" value="{{ old('nim') }}" placeholder="NIP/NIK/NIPPPK" aria-label="Nim"
                                        required autofocus>
                                    @error('nim')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input id="password" type="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        name="password" required placeholder="Password" aria-label="Password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                    <label class="form-check-label" for="rememberMe">Ingat Saya</label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 mb-0">Masuk</button>
                                </div>
                            </form>
                            <p class="mt-3 mb-3 text-sm mx-auto">
                                Masuk sebagai Mahasiswa?
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
