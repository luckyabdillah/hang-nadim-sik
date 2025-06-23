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
        <style>
            .container {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>
    </head>
    <body class="">
        <div class="container text-center">
            <div class="flash-data" data-flash="{{ $message }}"></div>
            <div class="row justify-content-center mb-4">
                <div class="col-lg-5 col-md-8 col-10">
                    <p style="font-size: 1.1rem;">Saat ini kami sedang memproses data Anda. Mohon pastikan untuk memeriksa email Anda guna mendapatkan informasi terbaru.</p>
                    <img src="{{ asset('assets/img/illustrations/win.png') }}" alt="Thank You" class="img-fluid my-3">
                </div>
            </div>
            <a href="/" class="btn btn-primary fw-medium">Kembali ke Beranda</a>
        </div>
        
        <script src="{{ asset('assets/libs/jquery/jquery-3.5.1.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', e => {
                const flashData = $('.flash-data').data('flash')
                if (flashData) {
                    new Swal({
                        title: 'Success',
                        text: flashData,
                        icon: 'success',
                        cancelButtonText: 'OK',
                        customClass: {
                            popup: 'rounded-4',
                            confirmButton: 'bg-primary',
                        }
                    })
                }
            })
        </script>
        @vite(['resources/js/app.js'])
    </body>
</html>