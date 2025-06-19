<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{ asset('assets/img/logo/icon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('assets/img/logo/icon.png') }}">

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/boxicons.css') }}" />
        @vite(['resources/sass/app.scss', 'resources/css/app.css'])
        @stack('styles')
    </head>
    <body class="bg-primary">
        @if (session()->has('success'))
            <div class="flash-data" data-flash="{{ session('success') }}"></div>
        @endif
        @if (session()->has('failed'))
            <div class="flash-data-failed" data-flash="{{ session('failed') }}"></div>
        @endif
        <!-- Navbar -->
        <header class="w-100 bg-white fixed-top">
            <nav class="navbar navbar-expand-xl py-3">
                <div class="container">
                    <a class="navbar-brand brand-logo fw-bold" href="/">
                        <img src="{{ asset('assets/img/logo/secondary.png') }}" class="img-fluid rounded me-2" width="150" alt="Logo">
                    </a>
                    <button class="navbar-toggler border-0 focus-ring" id="navbar-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header pb-0">
                            <h5 class="offcanvas-title brand-logo text-primary fw-bold" id="offcanvasNavbarLabel">
                                SIK - Hang Nadim
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1">
                                <li class="nav-item pe-3">
                                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Beranda</a>
                                </li>
                                <li class="nav-item pe-3">
                                    <a class="nav-link {{ Request::is('sik') ? 'active' : '' }}" href="/sik">SIK</a>
                                </li>
                                <li class="nav-item pe-3">
                                    <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="/contact">Kontak</a>
                                </li>
                                <li class="nav-item pe-3">
                                    <a class="nav-link {{ Request::is('register') ? 'active' : '' }}" href="/register">Daftar</a>
                                </li>
                            </ul>
                            <span class="d-block btn-auth-action">
                                @if (auth()->user())
                                    <div class="dropdown d-block">
                                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-user bx-sm px-2"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>
                                            <li><a class="dropdown-item" href="/dashboard/profile">Profil</a></li>
                                            <li>
                                                <form action="/logout" method="post">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item btn-logout text-danger">Keluar</a>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @else
                                    <a href="/login" class="btn btn-primary d-block px-3">Masuk</a>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- End Navbar -->

        <div class="wrapper">
            @yield('content')
        </div>

        <footer class="text-white py-5">
            <div class="container">
                <div class="row row-gap-4">
                    <div class="col-md-4 col-6">
                        <h6 class="fs-5 mb-3">Beranda</h6>
                        <ul class="navbar-nav fw-light">
                            <li class="nav-item lh-sm"><a href="/#" class="nav-link">PT Bandara Internasional Batam</a></li>
                            <li class="nav-item lh-sm"><a href="/#about" class="nav-link">Tentang</a></li>
                            <li class="nav-item lh-sm"><a href="/#guide" class="nav-link">Panduan Pembuatan SIK</a></li>
                            <li class="nav-item lh-sm"><a href="/#testimonials" class="nav-link">Testimoni</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-6">
                        <h6 class="fs-5 mb-3">Navigasi</h6>
                        <ul class="navbar-nav fw-light">
                            <li class="nav-item lh-sm"><a href="/" class="nav-link">Beranda</a></li>
                            <li class="nav-item lh-sm"><a href="/sik" class="nav-link">SIK</a></li>
                            <li class="nav-item lh-sm"><a href="/contact" class="nav-link">Kontak</a></li>
                            <li class="nav-item lh-sm"><a href="/register" class="nav-link d-inline-block">Daftar</a>/<a href="/login" class="nav-link d-inline-block">Masuk</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-6">
                        <h6 class="fs-5 mb-3">Sosial Media</h6>
                        <ul class="navbar-nav fw-light bx-ul">
                            <li class="nav-item lh-sm"><a target="_blank" href="https://www.bthairport.com" class="nav-link"><i class="bx bx-globe bx-fw bx-sm ms-1"></i> www.bthairport.com</a></li>
                            <li class="nav-item lh-sm"><a target="_blank" href="https://www.linkedin.com/" class="nav-link"><i class="bx bxl-facebook-square bx-fw bx-sm ms-1"></i> PT. Bandara Internasional Batam</a></li>
                            <li class="nav-item lh-sm"><a target="_blank" href="https://www.instagram.com/batamairport" class="nav-link" target="_blank"><i class="bx bxl-instagram bx-fw bx-sm ms-1"></i> @batamairport</a></li>
                            <li class="nav-item lh-sm"><a target="_blank" href="https://www.twitter.com/batamairport" class="nav-link"><i class="bx bxl-twitter bx-fw bx-sm ms-1"></i> @batamairport</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <script src="{{ asset('assets/libs/jquery/jquery-3.5.1.min.js') }}"></script>
        @vite('resources/js/app.js')
        @vite('resources/js/main.js')
        @stack('scripts')
    </body>
</html>