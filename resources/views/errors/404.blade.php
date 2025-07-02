@extends('layouts.main')

@section('content')
    <nav id="about" class="bg-white position-relative">
        <div class="container py-5 my-5">
            <div class="row g-3 py-5">
                <div class="col-md-6 my-auto">
                    <h1 class="text-primary fw-bold mb-3" style="font-size: 2.5em">Halaman yang dituju tidak dapat ditemukan.</h1>
                    <p class="mb-1" style="font-size: 1.1em">Mohon coba langkah berikut:</p>
                    <ul style="font-size: 1.1em">
                        <li class="mb-1">Kembali ke <a href="/">beranda</a> dan coba navigasi dari sana.</li>
                        <li>Jika Anda mengetik pada alamat web, pastikan Anda mengetik URL yang benar.</li>
                    </ul>
                </div>
                <div class="col-md-6 my-auto p-5">
                    <img src="{{ asset('assets/img/errors/404.svg') }}" alt="404" class="img-fluid">
                </div>
            </div>
        </div>
    </nav>
@endsection