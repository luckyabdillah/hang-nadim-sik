<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{ env('APP_NAME') }} | Dashboard</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/icon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/theme/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/theme/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/theme/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/theme/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/theme/assets/css/custom.css') }}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/theme/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/theme/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->
    @stack('styles')

    <!-- Helpers -->
    <script src="{{ asset('assets/theme/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/theme/assets/js/config.js') }}"></script>
</head>

<body>
    
    @if (session()->has('success'))
        <div class="flash-data" data-flash="{{ session('success') }}"></div>
    @endif
    @if (session()->has('failed'))
        <div class="flash-data-failed" data-flash="{{ session('failed') }}"></div>
    @endif

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('dashboard.partials.sidebar')
            <!-- / Menu -->

            <style>
                .navbar-wrapper {
                    /* background-color: rgba(255, 255, 255, .88) !important; */
                    background-color: #f5f5f9 !important;
                    backdrop-filter: saturate(200%) blur(6px);
                }
            </style>

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('dashboard.partials.navbar')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">

                        @yield('content')
                        {{-- <div class="row">
                            
                        </div> --}}
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>.
                                Well-maintained by
                                <a href="#" target="_blank" class="footer-link fw-bolder">Hang Nadim International Airport</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/theme/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/theme/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/theme/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/theme/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/theme/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/theme/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/theme/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/theme/assets/js/dashboards-analytics.js') }}"></script>

    <!-- SweetAlert2 JS -->
    <script src="{{ asset('assets/theme/assets/vendor/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    
    <script src="{{ asset('assets/theme/assets/js/script.js') }}"></script>

    @stack('scripts')
    {{-- <script async defer src="https://buttons.github.io/buttons.js"></script> --}}
</body>
</html>
