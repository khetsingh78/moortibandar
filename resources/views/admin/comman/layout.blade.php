<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    {{-- @yield('content') --}}
    <title>Moorti Admin Panel Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link href="{{ URL::asset('public/admin/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ URL::asset('public/admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('public/admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}"
        rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ URL::asset('public/admin/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ URL::asset('public/admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('public/admin/lib/toast/toastr.css') }}" rel="stylesheet">

    @stack('header')
</head>

<body>

    <div class="container-fluid position-relative d-flex p-0">



        <!-- Sidebar Start -->
        @include('admin/comman/sidebar')
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('admin/comman/header')
            <!-- Navbar End -->

            @yield('content')
            <!-- Sale & Revenue Start -->

            <!-- Footer Start -->
            @include('admin/comman/footer')
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ URL::asset('public/admin/lib/chart/chart.min.js') }}"></script>
    <script src="{{ URL::asset('public/admin/lib/easing/easing.min.js') }}"></script>
    <script src="{{ URL::asset('public/admin/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('public/admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::asset('public/admin/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ URL::asset('public/admin/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ URL::asset('public/admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ URL::asset('public/admin/lib/toast/toastr.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ URL::asset('public/admin/js/main.js') }}"></script>
    <script>
        @if (Session::has('SuccessMessage'))
            toastr.options.timeOut = 5000;
            toastr.success("{{ Session::get('SuccessMessage') }}");
        @endif
        @if (Session::has('ErrorMessage'))
            toastr.options.timeOut = 5000;
            toastr.error("{{ Session::get('ErrorMessage') }}");
        @endif
    </script>

    @stack('footer')
</body>

</html>
