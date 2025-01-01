<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ URL::asset('/public/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/public/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/public/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/public/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/public/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/public/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/public/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/public/css/style.css') }}" type="text/css">
    <link href="{{ URL::asset('public/admin/lib/toast/toastr.css') }}" rel="stylesheet">

    @stack('header')
</head>

<body>
    @include('partial/header')
    @yield('content')



    @include('partial/footer')

    {{-- <div class="whatsappButton">
        <a href="https://wa.me/6378015536" target="_blank">
            <div class=" mx-auto" style="height: 50px; width:50px;">
                <img src="{{ URL::asset('/public/assets/images/icons/whatsapp.png') }}" alt="whatsapp" srcset=""
                    style="height: 100%; width:100%" />
            </div>
        </a>
    </div>
    <div class="CallButton">
        <a href="tel:6378015536" target="_blank">
            <div class=" mx-auto" style="height: 50px; width:50px;">
                <img src="{{ URL::asset('/public/assets/images/icons/call.png') }}" alt="whatsapp" srcset=""
                    style="height: 100%; width:100%" />
            </div>
        </a>
    </div> --}}





    <script src="{{ URL::asset('/public/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ URL::asset('/public/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('/public/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('/public/js/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('/public/js/mixitup.min.js') }}"></script>
    <script src="{{ URL::asset('/public/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ URL::asset('/public/js/jquery.slicknav.js') }}"></script>
    <script src="{{ URL::asset('/public/js/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::asset('/public/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ URL::asset('/public/js/main.js') }}"></script>
    <script src="{{ URL::asset('public/admin/lib/toast/toastr.min.js') }}"></script>



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
