@extends('layouts.main')

@section('content')
    <nav id="about" class="bg-white position-relative">
        <div class="container py-5 my-5">
            <div class="row g-3 py-5">
                <div class="col-md-6 my-auto">
                    <h1 class="text-primary fw-bold mb-3" style="font-size: 2.5em">Maaf, sesi Anda saat ini telah kedaluwarsa :&#40;</h1>
                    <p id="redirect-warn">Anda akan diarahkan secara otomatis dalam <span id="timer">10</span> detik...</p>
                    <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
                </div>
                <div class="col-md-6 my-auto p-5">
                    <img src="{{ asset('assets/img/errors/419.svg') }}" alt="419" class="img-fluid">
                </div>
            </div>
        </div>
    </nav>
@endsection

@push('scripts')
    <script>
        let timer = document.querySelector('#timer')
        let second = parseInt(timer.innerText, 10)

        const timerInterval = setInterval(redirectTimer, 1000)

        function redirectTimer() {
            second -= 1
            timer.innerText = second

            if (second <= 0) {
                clearInterval(timerInterval)
                document.querySelector('#redirect-warn').innerText = 'Redirecting now...'
                setTimeout(() => {
                    window.location.href = '/'
                }, 500);
            }
        }
    </script>
@endpush