<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PWL Laravel Starter Code') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('css')
    @stack('styles')

</head>

<!-- Custom Style Override -->
<style>
    /* ===========================
       FONT GLOBAL & BASE COLOR
       =========================== */
    body {
        font-family: 'Poppins', sans-serif !important;
        background-color: #f5f5f5 !important;
        color: #333 !important;
    }

    /* ===========================
       SIDEBAR STYLE
       =========================== */
    .main-sidebar {
        background-color: #2b2b2b !important;
    }

    .main-sidebar .brand-link {
        background-color: #8B0000 !important;
        color: #fff !important;
        font-weight: 600;
        text-align: center;
        font-size: 14px !important;
        letter-spacing: 0.5px !important;
        padding: 12px 5px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    /* Logo di sidebar */
    .main-sidebar .brand-link .brand-image {
        width: 60px !important;
        height: 60px !important;
        object-fit: contain !important;
        border-radius: 50% !important;
        margin-bottom: 5px !important;
    }

    .main-sidebar .brand-link+.form-inline {
        margin-top: 10px !important;
    }

    .nav-sidebar {
        margin-top: 10px !important;
    }

    .main-sidebar .brand-link:hover {
        background-color: #a52a2a !important;
        color: #fff !important;
    }

    .main-sidebar .nav-sidebar .nav-link {
        font-size: 16px !important;
        font-weight: 500 !important;
        color: #e0e0e0 !important;
        padding: 10px 15px !important;
        border-radius: 6px !important;
        transition: all 0.2s ease-in-out;
    }

    .main-sidebar .nav-sidebar .nav-link:hover {
        background-color: #8B0000 !important;
        color: #fff !important;
    }

    .main-sidebar .nav-sidebar .nav-link.active {
        background-color: #8B0000 !important;
        color: #fff !important;
        font-weight: 600 !important;
    }

    .main-sidebar .nav-header {
        color: #bbb !important;
        font-size: 13px !important;
        font-weight: 600;
        margin-top: 10px;
    }

    /* ===========================
       CONTENT AREA
       =========================== */
    .content-wrapper {
        background-color: #f9f9f9 !important;
        padding: 20px !important;
    }

    .content-header h1 {
        color: #8B0000 !important;
        font-weight: 600 !important;
    }

    /* ===========================
       NAVBAR (TOP BAR)
       =========================== */
    .main-header.navbar {
        background-color: #8B0000 !important;
        color: #fff !important;
    }

    .main-header .nav-link {
        color: #fff !important;
    }

    .main-header .nav-link:hover {
        color: #f5f5f5 !important;
    }

    /* ===========================
       CARD STYLING
       =========================== */
    .card {
        border-radius: 10px !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #8B0000 !important;
        color: #fff !important;
        font-weight: 600;
    }

    /* ===========================
       FOOTER
       =========================== */
    footer {
        background-color: #2b2b2b !important;
        color: #ccc !important;
        padding: 10px 0;
        text-align: center;
        font-size: 14px;
    }

    /* ===========================
       CAROUSEL STYLE (LANDSCAPE)
       =========================== */
    #carouselK3 {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    #carouselK3 .carousel-item img {
        width: 100%;
        height: 280px;
        /* tinggi proporsional landscape */
        object-fit: cover;
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        #carouselK3 .carousel-item img {
            height: 200px;
        }
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('layouts.header')

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-success elevation-4">
            <a href="{{ url('/') }}" class="brand-link text-center">
                <img src="{{ asset('adminlte/dist/img/hmsampoerna1.png') }}"
                    alt="Logo"
                    class="brand-image elevation-3"
                    style="opacity:.9;">
                <span class="brand-text font-weight-bold mt-1">PT HM Sampoerna Tbk</span>
            </a>
            @include('layouts.sidebar')
        </aside>


        <!-- Content Wrapper -->
        <div class="content-wrapper">
            @include('layouts.breadcrumb')
            <section class="content">
                @yield('content')
            </section>
        </div>

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @stack('js')

    <!-- Script Carousel Otomatis -->
    <script>
        $(document).ready(function() {
            $('#carouselK3').carousel({
                interval: 5000, // ganti gambar setiap 5 detik
                ride: 'carousel',
                pause: false // tetap berjalan meski dihover
            });
        });
    </script>
</body>

</html>