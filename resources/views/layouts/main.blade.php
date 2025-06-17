<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ config('app.name', 'Laravel') }} - Work Permit Letter (SIK)</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
   <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Headland+One&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="assets/favicon.png" />
  <!-- Custom Styles -->
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .bg-custom-blue {
      background-color: #1e3a8a !important;
    }
    .bg-custom-blue-hover:hover {
      background-color: #1e40af !important;
    }
    .text-custom-blue {
      color: #1e3a8a !important;
    }
  </style>
   @yield('style')
</head>
<body class="text-dark bg-light">

  <!-- Navbar -->
  <header class="fixed-top bg-white shadow-sm">
    <nav class="navbar navbar-expand-md navbar-light container py-2">
      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
        <img src="{{ asset('assets/img/logo/secondary.png') }}" alt="Logo" height="30" class="me-2" />
      </a>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
        aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse mt-2 mt-md-0" id="navbarMenu">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-md-3">
          <li class="nav-item">
            <a class="nav-link text-dark {{ Request::is('/') ? 'fw-bold' : '' }}" href="{{ url('/') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark {{ Request::is('sik') ? 'fw-bold' : '' }}" href="{{ url('/sik') }}">SIK</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark {{ Request::is('contact') ? 'fw-bold' : '' }}" href="{{ url('/contact') }}">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="#">Register</a>
          </li>
        </ul>
        <a href="#" class="btn btn-sm text-white bg-custom-blue bg-custom-blue-hover ms-md-3 mt-2 mt-md-0">Login</a>
      </div>
    </nav>
  </header>

  <!-- Main Content -->
    <div class="wrapper">
        @yield('content')
    </div>

  <!-- Footer -->
  <footer class="bg-custom-blue text-white text-center py-4 mt-5">
    <p class="mb-0 small">&copy; 2025 Hang Nadim - SIK. All rights reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
