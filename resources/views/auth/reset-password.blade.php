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
                            <p class="mt-3">Segera daftar bersama 20+ vendor lainya</p>
                            <a href="/" class="btn btn-light"><i class="bx bx-chevron-left bx-sm"></i> Kembali</a>
                        </div>
                        <div class="col-lg-5">
                            <div class="mb-2 d-block d-lg-none">
                                <a href="/" class="text-white link-underline link-underline-opacity-0 fw-semibold fs-5"><i class="bx bx-chevron-left"></i> Kembali</a>
                            </div>
                            <div class="card rounded-4 border-0 shadow bg-white">
                                <div class="card-body px-4 py-4">
                                    <div class="card-title text-center mt-2 mb-4">
                                        <a href="/">
                                            {{-- <img src="{{ asset('assets/img/logo/square.png') }}" alt="Logo" class="img-fluid" style="max-width: 80px;"> --}}
                                            <img src="{{ asset('assets/img/logo/secondary.png') }}" alt="Logo" class="img-fluid w-50">
                                        </a>
                                    </div>
                                    <h4 class="text-primary fw-semibold mt-5 mb-3">Reset Password</h4>
                                    <form action="/reset-password" method="post">
                                        @csrf
                                        <!-- Password Reset Token -->
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                        <div class="mb-3">
                                            <label for="email" class="form-label required-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{ $request->email }}" placeholder="Email" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label required-label">Password Baru</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror non-hoverable non-focusable" name="password" id="password" autocomplete="off" placeholder="********" style="border-right: 0" required>
                                                <span class="input-group-text cursor-pointer btn-show-password" style="border-left: 0;"><i class="bx bx-hide"></i></span>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback text-start d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 pb-2">
                                            <label for="password_confirmation" class="form-label required-label">Konfirmasi Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror non-hoverable non-focusable" name="password_confirmation" id="password_confirmation" autocomplete="off" placeholder="********" style="border-right: 0" required>
                                                <span class="input-group-text cursor-pointer btn-show-password-confirm" style="border-left: 0;"><i class="bx bx-hide"></i></span>
                                            </div>
                                            @error('password_confirmation')
                                                <div class="invalid-feedback text-start d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary d-block btn-submit w-100 my-4">Reset</button>
                                        <div class="text-muted text-center mt-4 mb-2">
                                            Ingat password? <a href="/login" class="fw-semibold link-underline link-underline-opacity-0">Login</a>
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