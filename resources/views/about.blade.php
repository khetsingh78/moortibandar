@extends('partial/layouts')
@section('title', 'shop')

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

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <h1>About us</h1>
                </div>
                <div class="col-lg-6 col-md-6">

                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Instagram Begin -->
    <x-FooterImages />
    <!-- Instagram End -->


@endsection

@push('footer')
@endpush
