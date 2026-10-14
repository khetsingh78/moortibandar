<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">
    <meta name="description" content="{{ trim($__env->yieldContent('meta_description', 'Discover handcrafted spiritual statues and sacred home decor at Moorti Jeevan. Find meaningful pieces for your home, altar, and thoughtful gifts.')) }}">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="{{ trim($__env->yieldContent('canonical', url()->current())) }}">
    <meta property="og:site_name" content="Moorti Jeevan">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ trim($__env->yieldContent('title', 'Moorti Jeevan | Handcrafted Spiritual Decor')) }}">
    <meta property="og:description" content="{{ trim($__env->yieldContent('meta_description', 'Discover handcrafted spiritual statues and sacred home decor at Moorti Jeevan. Find meaningful pieces for your home, altar, and thoughtful gifts.')) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Moorti Jeevan | Handcrafted Spiritual Decor')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ URL::asset('/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('/css/style.css') }}" type="text/css">
    <link href="{{ URL::asset('admin/lib/toast/toastr.css') }}" rel="stylesheet">

    <style>
        :root {
            --store-bg: #f8f4f0;
            --store-panel: #ffffff;
            --store-panel-soft: #f4efe9;
            --store-ink: #1d1d1d;
            --store-muted: #6b6b6b;
            --store-gold: #b87c4a;
            --store-gold-deep: #824d2d;
            --store-border: rgba(17,17,17,0.08);
            --store-shadow: 0 22px 48px rgba(23, 23, 23, 0.08);
        }

        body {
            background: var(--store-bg);
            color: var(--store-ink);
            font-family: 'Montserrat', sans-serif;
        }

        a, button, input, textarea, select {
            transition: all 0.25s ease;
        }

        .site-btn,
        .primary-btn,
        .cart-btn,
        .button,
        .btn-primary {
            background: linear-gradient(135deg, #171717 0%, #4a3229 100%) !important;
            border: none !important;
            color: #fff !important;
            border-radius: 999px !important;
            box-shadow: none !important;
        }

        .site-btn:hover,
        .primary-btn:hover,
        .cart-btn:hover,
        .button:hover,
        .btn-primary:hover {
            background: linear-gradient(135deg, #2a211e 0%, #8f5d3c 100%) !important;
            color: #fff !important;
            transform: translateY(-1px);
        }

        .breadcrumb-option {
            background: transparent;
            padding: 30px 0 10px;
        }

        .breadcrumb__links {
            background: rgba(255,255,255,0.8);
            border: 1px solid var(--store-border);
            border-radius: 14px;
            padding: 14px 18px;
            box-shadow: none;
        }

        .breadcrumb__links a,
        .breadcrumb__links span {
            color: var(--store-ink);
            font-weight: 600;
        }

        .shop spad,
        .product-details,
        .contact,
        .about,
        .checkout,
        .cart,
        .wishlist {
            background: transparent;
        }

        .section-title h4,
        .section-title h2,
        .related__title h5,
        .product__details__text h3,
        .shop__sidebar .section-title h4,
        .contact__content .section-title h2 {
            color: var(--store-ink);
            font-weight: 800;
        }

        .product__item {
            background: #fff;
            border: 1px solid var(--store-border);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: none;
        }

        .product__item__pic {
            border-bottom: 1px solid rgba(17,17,17,0.04);
        }

        .product__item__text {
            padding: 18px 16px 20px;
        }

        .product__item__text h6 a {
            color: var(--store-ink);
            font-weight: 700;
        }

        .product__item__text h6 a:hover {
            color: var(--store-gold-deep);
        }

        .product__price {
            color: var(--store-gold-deep);
            font-weight: 800;
        }

        .filter__controls li {
            color: var(--store-muted);
            border-radius: 999px;
            padding: 8px 16px;
        }

        .filter__controls li.active {
            background: #171717;
            color: #fff;
        }

        .sidebar__categories,
        .shop__sidebar .sidebar__filter,
        .shop__sidebar .sidebar__sizes,
        .shop__sidebar .sidebar__color {
            background: var(--store-panel);
            border: 1px solid var(--store-border);
            border-radius: 20px;
            padding: 20px;
            box-shadow: none;
        }

        .card,
        .accordion .card {
            background: transparent;
            border: none;
        }

        .shop__sidebar .categories__accordion .card-heading a {
            color: var(--store-ink);
            font-weight: 700;
        }

        .product__details__pic {
            background: #fff;
            border: 1px solid var(--store-border);
            border-radius: 24px;
            padding: 12px;
        }

        .product__details__text {
            background: transparent;
        }

        .product__details__button .cart-btn {
            background: linear-gradient(135deg, #171717 0%, #5b4034 100%) !important;
            border-radius: 999px !important;
        }

        .product__details__widget {
            background: rgba(255,255,255,0.7);
            border: 1px solid var(--store-border);
            border-radius: 18px;
            padding: 20px;
        }

        .product__details__tab .nav-tabs {
            border-bottom: 1px solid var(--store-border);
        }

        .product__details__tab .nav-link {
            color: var(--store-muted);
            font-weight: 700;
        }

        .product__details__tab .nav-link.active {
            color: var(--store-ink);
            background-color: transparent;
            border-color: var(--store-border) var(--store-border) transparent;
        }

        .checkout__order,
        .cart__total,
        .wishlist__table,
        .contact__content,
        .about__text {
            background: #fff;
            border: 1px solid var(--store-border);
            border-radius: 20px;
            box-shadow: none;
        }

        .header {
            background: rgba(255, 255, 255, 0.92);
            border-bottom: 1px solid rgba(17,17,17,0.05);
            backdrop-filter: blur(10px);
        }

        .header__menu ul li a,
        .header__right__auth a,
        .header__right__widget li span,
        .header__right__widget li a {
            color: var(--store-ink);
        }

        .header__menu ul li.active > a,
        .header__menu ul li:hover > a {
            color: var(--store-gold-deep);
        }

        .header__right__widget .tip {
            background: var(--store-gold-deep);
            color: #fff;
        }

        @media (max-width: 767px) {
            .header__menu {
                display: none;
            }
        }
    </style>

    @stack('header')
</head>

<body>
    @include('partial/header')
    @yield('content')



    @include('partial/footer')

    {{-- <div class="whatsappButton">
        <a href="https://wa.me/6378015536" target="_blank">
            <div class=" mx-auto" style="height: 50px; width:50px;">
                <img src="{{ URL::asset('/assets/images/icons/whatsapp.png') }}" alt="whatsapp" srcset=""
                    style="height: 100%; width:100%" />
            </div>
        </a>
    </div>
    <div class="CallButton">
        <a href="tel:6378015536" target="_blank">
            <div class=" mx-auto" style="height: 50px; width:50px;">
                <img src="{{ URL::asset('/assets/images/icons/call.png') }}" alt="whatsapp" srcset=""
                    style="height: 100%; width:100%" />
            </div>
        </a>
    </div> --}}




    <script src="{{ URL::asset('/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ URL::asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('/js/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('/js/mixitup.min.js') }}"></script>
    <script src="{{ URL::asset('/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ URL::asset('/js/jquery.slicknav.js') }}"></script>
    <script src="{{ URL::asset('/js/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::asset('/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ URL::asset('/js/main.js') }}"></script>
    <script src="{{ URL::asset('/js/ajax.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/toast/toastr.min.js') }}"></script>
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function sweet(status, message) {
            Swal.fire({
                toast: true,
                position: 'top-end', // Top-right
                icon: status === "success" ? 'success' : 'error',
                title: message,
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        }
    </script>
    @stack('footer')

</body>

</html>
