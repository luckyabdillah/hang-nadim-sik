@extends('layouts.main')

@section('content')
    <nav id="about" class="bg-white position-relative">
        <div class="container py-5 my-5">
            <div class="row g-3 py-5">
                <div class="col-md-6 my-auto">
                    <h1 class="text-primary fw-bold mb-3" style="font-size: 2.5em">Layanan saat ini tidak tersedia.</h1>
                    <p class="mb-1" style="font-size: 1.1em">Mohon maaf atas ketidaknyamanannya, silakan coba lagi dalam beberapa menit.</p>
                </div>
                <div class="col-md-6 my-auto p-5">
                    <img src="{{ asset('assets/img/errors/5xx.svg') }}" alt="5xx" class="img-fluid">
                </div>
            </div>
        </div>
    </nav>
@endsection