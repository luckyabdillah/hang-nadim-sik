<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{ asset('assets/img/logo/icon.ico') }}" type="image/x-icon">

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/boxicons.css') }}" />
        @vite(['resources/sass/app.scss', 'resources/css/app.css'])
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    </head>
    <body class="bg-primary">
        @if (session()->has('success'))
            <div class="flash-data" data-flash="{{ session('success') }}"></div>
        @endif
        @if (session()->has('failed'))
            <div class="flash-data-failed" data-flash="{{ session('failed') }}"></div>
        @endif
        <div class="wrapper">
            <nav id="hero" style="min-height: 100dvh; background-image: url('{{ asset('assets/img/background/auth.png') }}')">
                <div class="container h-100 py-5 text-white position-relative z-1">
                    <div class="row h-100 d-flex align-items-center">
                        <div class="col-lg-7 d-none d-lg-block">
                            <h6 class="fw-semibold my-3">
                                <img src="{{ asset('assets/img/icon/airplane.png') }}" alt="" width="25em" class="img-fluid">
                                &nbsp;PT Bandara Internasional Batam
                            </h6>
                            <h1 class="fw-semibold lh-sm hero-tagline-login" style="font-size: 3.25em;">Pengajuan <span class="bg-orange text-white px-2">SIK</span> menjadi mudah dengan sistem terdigitalisasi</h1>
                            <p class="mt-3">Segera daftar bersama 20+ vendor lainnya</p>
                            <a href="/" class="btn btn-light"><i class="bx bx-chevron-left bx-sm"></i> Kembali</a>
                        </div>
                        <div class="col-lg-5">
                            <div class="mb-2 d-block d-lg-none">
                                <a href="/" class="text-white link-underline link-underline-opacity-0 fw-semibold fs-5"><i class="bx bx-chevron-left"></i> Kembali</a>
                            </div>
                            <div class="card rounded-4 border-0 shadow bg-white">
                                <div class="card-body px-4 py-4">
                                    <div class="card-title text-center mt-3 mb-4">
                                        <a href="/">
                                            {{-- <img src="{{ asset('assets/img/logo/square.png') }}" alt="Logo" class="img-fluid" style="max-width: 80px;"> --}}
                                            <img src="{{ asset('assets/img/logo/secondary.png') }}" alt="Logo" class="img-fluid w-50">
                                        </a>
                                    </div>
                                    <form action="/login" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label required-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" autocomplete="off" placeholder="Masukkan email" value="{{ old('email') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label required-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control non-hoverable non-focusable" name="password" id="password" autocomplete="off" placeholder="********" style="border-right: 0" required>
                                                <span class="input-group-text cursor-pointer btn-show-password" style="border-left: 0;"><i class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center my-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="on" name="remember_me" id="remember_me">
                                                <label class="form-check-label text-primary" for="remember_me">Ingat saya</label>
                                            </div>
                                            <div>
                                                <a href="/forgot-password" class="fw-semibold link-underline link-underline-opacity-0">Lupa password?</a>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary d-block btn-submit w-100">Masuk</button>
                                        {{-- <a href="/dashboard" class="btn btn-primary d-block btn-submit w-100">Masuk</a> --}}
                                        <div class="text-muted text-center mt-4 mb-2 dropup">
                                            Belum punya akun? <a href="/register" class="fw-semibold link-underline link-underline-opacity-0">Daftar Sekarang</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        @vite(['resources/js/app.js'])
        <script src="{{ asset('assets/libs/jquery/jquery-3.5.1.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', e => {
                const passwordField = document.querySelector('#password')
                const btnShowPassword = document.querySelector('.btn-show-password')
                btnShowPassword.addEventListener('click', e => {
                    if (passwordField.getAttribute('type') == 'password') {
                        btnShowPassword.innerHTML = '<i class="bx bx-show"></i>'
                        passwordField.setAttribute('type', 'text')
                    } else {
                        btnShowPassword.innerHTML = '<i class="bx bx-hide"></i>'
                        passwordField.setAttribute('type', 'password')
                    }
                })

                document.querySelector('form').addEventListener('submit', function(e) {
                    e.preventDefault()
                    const container = e.target
                    const submitBtn = container.querySelector('.btn-submit')
                    const submitBtnWidth = submitBtn.offsetWidth;
                    submitBtn.style.width = `${submitBtnWidth}px`;

                    submitBtn.setAttribute('disabled', true)
                    submitBtn.innerHTML = `
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    `
                    return this.submit()
                })
    
                const flashData = $('.flash-data').data('flash')
                if (flashData) {
                    new Swal({
                        title: 'Success',
                        text: flashData,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            popup: 'rounded-4',
                            confirmButton: 'px-4 bg-primary rounded-3',
                        }
                    })
                }
    
                const flashDataFailed = $('.flash-data-failed').data('flash')
                if (flashDataFailed) {
                    new Swal({
                        title: 'Oops!',
                        text: flashDataFailed,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            popup: 'rounded-4',
                            confirmButton: 'px-4 bg-primary rounded-3',
                        }
                    })
                }
            })
        </script>
    </body>
</html>