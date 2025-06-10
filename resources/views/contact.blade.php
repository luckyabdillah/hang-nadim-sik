@extends('layouts.main')

@section('style')
<style>
  body {
    font-family: 'Inter', sans-serif;
    color: #1f2937;
  }
  .bg-blue-900 {
    background-color: #1e3a8a !important;
  }
  .bg-blue-100 {
    background-color: #dbeafe !important;
  }
  .text-blue-700 {
    color: #1d4ed8 !important;
  }
  .hover-blue-800:hover {
    background-color: #1e40af !important;
  }
  .rounded-40 {
    border-bottom-left-radius: 40px;
    border-bottom-right-radius: 40px;
  }
</style>
@endsection

@section('content')
  <!-- Hero Section -->
    <section class="position-relative" style="height: 420px; background: url('{{ asset('assets/img/background/telepon.png') }}') center/cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(30, 58, 138, 0.6);"></div>
        <div class="position-relative d-flex align-items-center justify-content-center h-100">
            <h1 class="text-white fw-bold display-4 text-center">CONTACT US</h1>
        </div>
    </section>


  <!-- Contact Section -->
  <section class="bg-white rounded-top-4 shadow-lg mt-n5 position-relative z-1 py-5">
    <div class="container">
      <div class="row g-4">
        <!-- Contact Info -->
        <div class="col-md-6 bg-blue-100 rounded p-4">
          <h2 class="fs-5 fw-semibold">Contact Information</h2>
          <p class="d-flex align-items-center gap-2">
            <i class="fas fa-phone text-blue-700"></i> (0778) 7630660
          </p>
          <p class="d-flex align-items-center gap-2">
            <i class="fas fa-envelope text-blue-700"></i> info@bthairport.com
          </p>
          <p class="d-flex gap-2">
            <i class="fas fa-map-marker-alt text-blue-700 mt-1"></i>
            <span>
              Jl. Hang Nadim no. 01 (Area Perkantoran Lt. 2)<br/>
              Batu Besar, Nongsa, Kota Batam, Kepulauan Riau 29466
            </span>
          </p>

          <h3 class="fs-6 fw-semibold mt-4">Social Media</h3>
          <ul class="list-unstyled">
            <li class="d-flex align-items-center gap-2">
              <i class="fas fa-globe text-blue-700"></i>
              <a href="https://www.bthairport.com" class="text-decoration-none" target="_blank">www.bthairport.com</a>
            </li>
            <li class="d-flex align-items-center gap-2 mt-2">
              <i class="fab fa-instagram text-danger"></i>
              <a href="https://www.instagram.com/batamairport" class="text-decoration-none" target="_blank">@batamairport</a>
            </li>
            <li class="d-flex align-items-center gap-2 mt-2">
              <i class="fab fa-youtube text-danger"></i>
              <a href="https://www.youtube.com" class="text-decoration-none" target="_blank">PT. Bandara Internasional Batam</a>
            </li>
          </ul>
        </div>

        <!-- Contact Form -->
        <div class="col-md-6">
          <form>
            <div class="row g-3">
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Enter your name" />
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Enter your vendor name" />
              </div>
            </div>
            <div class="mt-3">
              <input type="email" class="form-control" placeholder="Enter your email" />
            </div>
            <div class="mt-3">
              <input type="text" class="form-control" placeholder="Title" />
            </div>
            <div class="mt-3">
              <textarea class="form-control" rows="4" placeholder="Write your message"></textarea>
            </div>
            <div class="mt-4">
              <button type="submit" class="btn bg-blue-900 text-white w-100 hover-blue-800">SEND</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection
