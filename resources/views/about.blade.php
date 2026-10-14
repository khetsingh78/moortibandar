@extends('partial/layouts')
@section('title', 'About Moorti Jeevan | Our Story')
@section('meta_description', 'Learn about Moorti Jeevan, a destination for handcrafted spiritual statues and meaningful decor for homes, prayer spaces, and gifting.')

@push('header')
    <style>

    </style>
@endpush

@section('content')

    <!-- Breadcrumb Begin -->

    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                        <span>About Us</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <section class="about spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="about__text">
                        <h1>About Moorti Jeevan</h1>
                        <p>Moorti Jeevan brings together spiritual statues and devotional decor for homes and prayer spaces. Explore figures from Jain and Hindu traditions, with product details to help you choose a piece that feels right for your space.</p>
                        <p>Whether you are creating a peaceful place for prayer or choosing a meaningful gift, our collection is here to make that search easier. Browse the collection and contact us if you have a question about a product or order.</p>
                        <a class="site-btn" href="{{ route('shop', ['category' => 'all-product']) }}">Explore the collection</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Instagram Begin -->
    <x-FooterImages />
    <!-- Instagram End -->


@endsection

@push('footer')
@endpush
