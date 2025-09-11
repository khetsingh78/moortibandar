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
    <link href="{{ URL::asset('admin/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ URL::asset('admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}"
        rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ URL::asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ URL::asset('admin/css/style.css') }}" rel="stylesheet">
</head>

<body>
    @yield('content')



    
    @if (Session::has('ErrorMessage'))
        <div class="toast align-items-center  bg-danger" id="liveToast" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
            <div class="d-flex">
                <div class="toast-body overflow-auto">
                    {{ Session::get('ErrorMessage') }}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    @endif
    @if (Session::has('SuccessMessage'))
        <div class="toast align-items-center" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-delay="5000" data-bs-autohide="true">
            <div class="d-flex">
                <div class="toast-body overflow-auto">
                    {{ Session::get('SuccessMessage') }}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::asset('admin/lib/chart/chart.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/easing/easing.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ URL::asset('admin/js/main.js') }}"></script>
    @stack('footer')
</body>

</html>
