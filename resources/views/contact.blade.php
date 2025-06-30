@extends('layouts.main')

@section('content')
    <nav id="hero" style="height: 18em; background-image: url('{{ asset('assets/img/background/contact.png') }}');">
        <div class="container py-5 mt-5 text-white position-relative z-1 h-100 d-flex justify-content-center align-items-center">
            <h1 class="">Kontak</h1>
        </div>
    </nav>
    <nav id="contact" class="bg-white rounded-5 rounded-bottom-0 position-relative" style="margin-top: -27px;">
        <div class="container py-5">
            <h3 class="text-primary fw-semibold mb-3">Kontak</h3>
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kontak</li>
                    </ol>
                </nav>
            </div>
            <div class="row row-gap-4 justify-content-around pb-5 pt-2">
                <div class="col-md-4 bg-primary-subtle rounded-4 p-4 order-md-1 order-2">
                    <div class="mb-4">
                        <h3>Informasi Kontak</h3>
                        <ul class="navbar-nav bx-ul">
                            <li class="nav-item"><a href="tel:08117002313" class="nav-link pb-1"><i class="bx bxs-phone bx-fw bx-sm ms-1"></i> 0811-7002-313</a></li>
                            <li class="nav-item"><a href="mailto:info@bthairport.com" class="nav-link pb-1"><i class="bx bxs-envelope bx-fw bx-sm ms-1"></i> info@bthairport.com</a></li>
                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link pb-1"><i class="bx bxs-map bx-fw bx-sm ms-1"></i> Jl. Hang Nadim no. 01 (Area Perkantoran Lt. 2) Batu Besar, Nongsa, Kota Batam, Kepulauan Riau - 29466</a></li>
                        </ul>
                    </div>
                    <div class="">
                        <h4>Sosial Media</h4>
                        <ul class="navbar-nav bx-ul">
                            <li class="nav-item"><a target="_blank" href="https://www.bthairport.com" class="nav-link"><i class="bx bx-globe bx-fw bx-sm ms-1"></i> www.bthairport.com</a></li>
                            <li class="nav-item"><a target="_blank" href="https://www.linkedin.com/" class="nav-link"><i class="bx bxl-facebook-square bx-fw bx-sm ms-1"></i> PT. Bandara Internasional Batam</a></li>
                            <li class="nav-item"><a target="_blank" href="https://www.instagram.com/batamairport" class="nav-link" target="_blank"><i class="bx bxl-instagram bx-fw bx-sm ms-1"></i> @batamairport</a></li>
                            <li class="nav-item"><a target="_blank" href="https://www.twitter.com/batamairport" class="nav-link"><i class="bx bxl-twitter bx-fw bx-sm ms-1"></i> @batamairport</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7 order-md-2 order-1">
                    <form action="/contact" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label required-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" id="name" autocomplete="off" value="{{ old('name', $agent->name ?? '') }}" placeholder="Nama lengkap" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label required-label">Alamat Email</label>
                                <input type="email" class="form-control" name="email" id="email" autocomplete="off" value="{{ old('email', $agent->email ?? '') }}" placeholder="Alamat email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="whatsapp_number" class="form-label required-label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text px-3" style="border-right: 0;">+62</span>
                                    <input type="number" name="whatsapp_number" id="whatsapp_number" class="form-control textfield-appearance" value="{{ old('whatsapp_number', $agent->whatsapp_number ?? '') }}" placeholder="8XXXXXXXXXX" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label required-label">Judul</label>
                            <input type="text" class="form-control" name="title" id="title" autocomplete="off" value="{{ old('title', request('title') ?? '') }}" placeholder="Judul" required maxlength="100">
                        </div>
                        <div class="mb-4">
                            <label for="message" class="form-label required-label">Pesan</label>
                            <textarea name="message" id="message" rows="4" class="form-control" placeholder="Tulis pesan" autocomplete="off" required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary d-block w-100 btn-submit">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-4.1.0.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap-5-theme-1.3.0.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/jquery/jquery-3.5.1.min.js') }}"></script>
@endpush