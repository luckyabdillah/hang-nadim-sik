@extends('layouts.main')

@section('content')
    <nav id="hero" style="height: 18em; background-image: url('{{ asset('assets/img/background/sik.png') }}');">
        <div class="container py-5 mt-5 text-white position-relative z-1 h-100 d-flex justify-content-center align-items-center">
            <h1 class="">Surat Izin Kerja (SIK)</h1>
        </div>
    </nav>
    <nav id="sik" class="bg-white rounded-5 rounded-bottom-0 position-relative" style="margin-top: -27px;">
        <div class="container py-5">
          <h3 class="text-primary fw-semibold mb-3">SIK</h3>
          <div class="mb-4">
              <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                      <li class="breadcrumb-item active" aria-current="page">SIK</li>
                  </ol>
              </nav>
          </div>
          <div class="table-responsive text-nowrap">
              <table class="table table-bordered table-hover data-table">
                  <thead>
                      <tr>
                          <th style="width: 1px;" class="text-center px-3">No</th>
                          <th class="text-center">Vendor</th>
                          <th class="text-center">Deskripsi</th>
                          <th class="text-center">Tanggal</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($workPermitLetters as $letter)
                          <tr>
                              <td class="text-center">{{ $loop->iteration }}</td>
                              <td class="text-center">{{ $letter->vendor->name }}</td>
                              <td class="text-center text-wrap">{{ $letter->description }}</td>
                              <td class="text-center">{{ date('d/m/Y', strtotime($letter->started_at)) }} - {{ date('d/m/Y', strtotime($letter->ended_at)) }}</td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
              {{ $workPermitLetters->links() }}
          </div>
        </div>
    </nav>
@endsection

{{-- @push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/datatable-bootstrap5-2.0.1.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/datatable/datatable-2.0.1.min.js') }}"></script>
    <script>
        $('.data-table').DataTable({
            autoWidth: false,
            initComplete: function() {
                $(this.api().table().container()).find('input').attr('autocomplete', 'off')
            },
        })
    </script>
@endpush --}}

{{-- @extends('layouts.main')

@section('style')
<style>
  body {
    font-family: 'Inter', sans-serif;
    background-color: #f8f9fa;
  }
  .bg-blue-900 {
    background-color: #1e3a8a;
  }
  .rounded-top-40px {
    border-top-left-radius: 40px;
    border-top-right-radius: 40px;
  }
  .hero-section {
    height: 320px;
    position: relative;
    overflow: hidden;
  }
  .hero-overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(30, 58, 138, 0.8);
    z-index: 1;
  }
  .hero-image {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.7;
    z-index: 0;
  }
  .hero-text {
    position: relative;
    z-index: 2;
  }
  table thead {
    background-color: #1e3a8a;
    color: white;
  }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="hero-section mt-5">
  <div class="hero-overlay" style="background-color: rgba(30, 58, 138, 0.6);"></div>
  <img src="{{ asset('assets/img/background/buku.png') }}" alt="Background" class="hero-image">
  <div class="d-flex justify-content-center align-items-center h-100 hero-text">
    <h1 class="text-white fw-bold text-center">WORK PERMIT LETTER (SIK)</h1>
  </div>
</div>

<!-- Main Form Area -->
<div class="container bg-white border rounded-top-40px shadow mt-n5 py-5 px-4">
  <h2 class="fw-bold mb-4">WORK PERMIT LETTER (SIK)</h2>

  <!-- Filter Controls -->
  <div class="row align-items-center mb-3">
    <div class="col-md-6 d-flex align-items-center gap-2">
      <select class="form-select form-select-sm w-auto">
        <option>1</option>
        <option>5</option>
        <option>10</option>
      </select>
      <span class="text-muted small">Entries per pages</span>
    </div>
    <div class="col-md-6 d-flex justify-content-md-end align-items-center gap-2">
      <span class="text-primary small fw-medium">Search :</span>
      <input type="text" class="form-control form-control-sm w-50" />
    </div>
  </div>

  <!-- Data Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle text-center">
      <thead>
        <tr>
          <th scope="col">NO</th>
          <th scope="col">VENDOR NAME</th>
          <th scope="col">DESCRIPTION</th>
          <th scope="col">DATE</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>PT Contoh Vendor</td>
          <td>Perbaikan sistem kelistrikan</td>
          <td>2025-05-30</td>
        </tr>
        <tr><td colspan="4" style="height: 40px;"></td></tr>
        <tr><td colspan="4" style="height: 40px;"></td></tr>
      </tbody>
    </table>
  </div>

  <div class="small text-muted mt-3">Showing 1 of 1 entries</div>
</div>
@endsection --}}
