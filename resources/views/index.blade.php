@extends('layouts.main')

@section('content')
    <nav id="hero" style="background-image: url('{{ asset('assets/img/background/home.png') }}')">
        <div class="container py-5 my-5 text-white position-relative z-1">
            <h6 class="fw-semibold mb-3 mt-4">
                <img src="{{ asset('assets/img/icon/airplane.png') }}" alt="" width="25em" class="img-fluid">
                &nbsp;PT Bandara Internasional Batam
            </h6>
            <h1 class="fw-semibold lh-sm hero-tagline" style="font-size: 3.25em;">Pengajuan <span class="bg-orange text-white px-2">SIK</span> menjadi mudah dengan sistem terdigitalisasi</h1>
            <p class="mt-3 mb-4">Segera daftar bersama 20+ vendor lainnya</p>
            <div class="text-center text-md-start pb-4">
                <a href="/login" class="btn btn-light fw-semibold px-3">Mulai Sekarang</a>
            </div>
        </div>
    </nav>
    <nav id="about" class="bg-white rounded-5 rounded-bottom-0 position-relative" style="margin-top: -70px;">
        <div class="container py-5">
            <div class="row row-gap-4 pt-5">
                <div class="col-md-6 my-auto order-md-1 order-2">
                    <h3 class="text-primary fw-semibold fs-1">Sistem Surat Izin Kerja</h3>
                    <p class="my-4">Sistem Surat Izin Kerja (SIK) adalah aplikasi berbasis web yang dirancang untuk menangani proses pengajuan, verifikasi, persetujuan, dan penerbitan SIK secara digital. Sistem ini bertujuan untuk meningkatkan efisiensi dalam pengelolaan surat izin kerja serta mengurangi kesalahan administratif.</p>
                    <a href="/contact" class="btn btn-primary">Kontak Kami</a>
                </div>
                <div class="col-md-6 order-md-2 order-1 text-center">
                    <img src="{{ asset('assets/img/background/about.png') }}" alt="" class="img-fluid w-75">
                </div>
            </div>
        </div>
    </nav>
    <nav id="guide" class="bg-white py-5">
        <div class="container">
            <h3 class="text-primary fw-semibold fs-2 mb-4 pb-1">Panduan Pembuatan SIK</h3>
            <div class="card rounded-5 border-0 text-white shadow py-5" style="background-image: url({{ asset('assets/img/background/guide.png') }}); background-size: cover; background-repeat: no-repeat; background-position: center;">
                <div class="row justify-content-center text-center g-3">
                    <div class="col-lg col-md-6 px-4">
                        <img src="{{ asset('assets/img/icon/guide-1.png') }}" alt="" class="img-fluid px-5 mb-4">
                        <h5 class="fw-semibold">Pengajuan oleh Pihak Eksternal</h5>
                        <hr>
                        <p class="mb-4">Pihak eksternal (kontraktor/vendor) mengisi formulir pengajuan SIK.</p>
                    </div>
                    <div class="col-lg col-md-6 px-4">
                      <img src="{{ asset('assets/img/icon/guide-2.png') }}" alt="" class="img-fluid px-5 mb-4">
                        <h5 class="fw-semibold">Verifikasi <span class="d-md-inline-block d-none">&nbsp;</span>Dokumen</h5>
                        <hr>
                        <p class="mb-4">Pihak internal menerima dan memeriksa kelengkapan data yang telah diajukan.</p>
                    </div>
                    <div class="col-lg col-md-6 px-4">
                        <img src="{{ asset('assets/img/icon/guide-3.png') }}" alt="" class="img-fluid px-5 mb-4">
                        <h5 class="fw-semibold">Persetujuan oleh Pejabat Internal</h5>
                        <hr>
                        <p class="mb-4">Pejabat internal akan meninjau dan menyetujui pengajuan SIK.</p>
                    </div>
                    <div class="col-lg col-md-6 px-4">
                        <img src="{{ asset('assets/img/icon/guide-4.png') }}" alt="" class="img-fluid px-5 mb-4">
                        <h5 class="fw-semibold">Penerbitan Surat Izin Kerja</h5>
                        <hr>
                        <p class="mb-4">Setelah mendapatkan persetujuan, SIK akan diterbitkan berdasarkan data yang telah disetujui.</p>
                    </div>
                    <div class="col-lg col-md-6 px-4">
                        <img src="{{ asset('assets/img/icon/guide-5.png') }}" alt="" class="img-fluid px-5 mb-4">
                        <h5 class="fw-semibold">Pemantauan oleh AVSEC</h5>
                        <hr>
                        <p class="mb-4">AVSEC dapat melihat daftar pekerjaan aktif saat melakukan patroli di area kerja.</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <nav id="testimonials" class="bg-white py-5 rounded-5 rounded-top-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 my-auto">
                    <h6 class="fs-1 fw-semibold text-primary">Lihat Apa Kata Vendor Tentang Sistem SIK!</h6>
                    <div class="text-center text-lg-start d-none d-lg-block">
                        <a href="/login" class="btn btn-primary mt-4 px-3">Mulai Sekarang</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div id="carouselExampleDark" class="carousel carousel-dark slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-bs-interval="10000">
                                <div style="min-height: 280px;">
                                    <div class="carousel-caption d-block text-start">
                                      <h1 class="mb-0 pb-0">"</h1>
                                      <p>Website untuk pembuatan Surat Izin Kerja (SIK) ini sangat membantu dengan proses yang jelas, cepat, dan transparan. Alur pengajuannya terstruktur dengan baik, sehingga memudahkan pengguna dalam mengajukan izin.</p>
                                      <h5><span class="rounded-circle bg-danger px-2 py-1 text-white d-inline-block me-1">K</span> Kek Pisang Vila</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item" data-bs-interval="2000">
                                <div style="min-height: 280px;">
                                    <div class="carousel-caption d-block text-start">
                                      <h1 class="mb-0 pb-0">"</h1>
                                      <p>Website untuk pembuatan Surat Izin Kerja (SIK) ini sangat membantu dengan proses yang jelas, cepat, dan transparan. Alur pengajuannya terstruktur dengan baik, sehingga memudahkan pengguna dalam mengajukan izin.</p>
                                      <h5><span class="rounded-circle bg-warning px-2 py-1 text-white d-inline-block me-1">R</span> RM Sederhana</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div style="min-height: 280px;">
                                    <div class="carousel-caption d-block text-start">
                                      <h1 class="mb-0 pb-0">"</h1>
                                      <p>Website untuk pembuatan Surat Izin Kerja (SIK) ini sangat membantu dengan proses yang jelas, cepat, dan transparan. Alur pengajuannya terstruktur dengan baik, sehingga memudahkan pengguna dalam mengajukan izin.</p>
                                      <h5><span class="rounded-circle bg-success px-2 py-1 text-white d-inline-block me-1">M</span> MM Cafe</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="text-center text-lg-start d-block d-lg-none">
                        <a href="/login" class="btn btn-primary px-3">Mulai Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endsection