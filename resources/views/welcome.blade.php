@extends('partial/layouts')
{{-- @section('title', 'Moorti store') --}}

@push('header')
    <style>

    </style>
@endpush


@section('content')
    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="categories__item categories__large__item set-bg"
                        data-setbg="{{ URL::asset('/img/categories/parasnath-moorti.jpg') }}">
                        <div class="categories__text">
                            <h1>Jain Collection Statue</h1>
                            <p>Sitamet, consectetur adipiscing elit, sed do eiusmod tempor incidid-unt labore
                                edolore magna aliquapendisse ultrices gravida.</p>
                            <a href="{{ route('shop', ['category' => 'jain-statue']) }}">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                            <div class="categories__item set-bg"
                                data-setbg="{{ URL::asset('/img/categories/ganesh-moorti.jpg') }}">
                                <div class="categories__text">
                                    <h4>Hindu Statue</h4>
                                    <p>358 items</p>
                                    <a href="{{ route('shop', ['category' => 'hindu-statue']) }}">Shop now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                            <div class="categories__item set-bg"
                                data-setbg="{{ URL::asset('/img/categories/mahavir-moorti.jpg') }}">
                                <div class="categories__text">
                                    <h4>Mahavir Moorti</h4>
                                    <p>273 items</p>
                                    <a href="{{ route('shop', ['category' => 'mahavir']) }}">Shop
                                        now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                            <div class="categories__item set-bg"
                                data-setbg="{{ URL::asset('/img/categories/parasnath-statue.jpg') }}">
                                <div class="categories__text">
                                    <h4>Parasnath Moorti</h4>
                                    <p>159 items</p>
                                    <a href="{{ route('shop', ['category' => 'parasnath']) }}">Shop
                                        now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                            <div class="categories__item set-bg"
                                data-setbg="{{ URL::asset('/img/categories/gautam-swami-moorti.jpg') }}">
                                <div class="categories__text">
                                    <h4>Gautam Swami Moorti</h4>
                                    <p>792 items</p>
                                    <a href="{{ route('shop', ['category' => 'gautam-swami']) }}">Shop
                                        now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="section-title">
                        <h4>New product</h4>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">All</li>
                        <li data-filter=".jain-statue">Jain statue</li>
                        <li data-filter=".hindu-statue">Hindi statue</li>
                        {{-- <li data-filter=".mahavir">Mahavir</li> --}}
                        {{-- <li data-filter=".accessories">Accessories</li>
                        <li data-filter=".cosmetic">Cosmetics</li> --}}
                    </ul>
                </div>
            </div>


            <div class="row property__gallery">
                @foreach ($products ?? [] as $key => $item)
                    <div
                        class="col-lg-3 col-md-4 col-sm-6 mix {{ $item['category']['name'] ?? '' }} {{ $item['category']['name'] ?? '' }}">
                        <x-product-item :item="$item" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Banner Section Begin -->
    <section class="banner set-bg" data-setbg="{{ URL::asset('/img/banner/banner-1.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8 m-auto">
                    <div class="banner__slider owl-carousel">
                        <div class="banner__item">
                            <div class="banner__text">
                                <span>The Chloe Collection</span>
                                <h1>The Project Jacket</h1>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                        <div class="banner__item">
                            <div class="banner__text">
                                <span>The Chloe Collection</span>
                                <h1>The Project Jacket</h1>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                        <div class="banner__item">
                            <div class="banner__text">
                                <span>The Chloe Collection</span>
                                <h1>The Project Jacket</h1>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Trend Section Begin -->
    <section class="trend spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="trend__content">
                        <div class="section-title">
                            <h4>Hot Trend</h4>
                        </div>

                        @foreach ($trend ?? [] as $key => $item)
                            <div class="trend__item">
                                <div class="trend__item__pic">
                                    <img src="{{ URL::asset($item->cover_image ?? '') }}" alt="" width="100px"
                                        height="100px">
                                </div>
                                <div class="trend__item__text">
                                    <h6>{{ $item->title ?? '' }}</h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="product__price">&#8377; {{ $item->inventory->price ?? '' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="trend__content">
                        <div class="section-title">
                            <h4>Best seller</h4>
                        </div>
                        @foreach ($trend ?? [] as $key => $item)
                            <div class="trend__item">
                                <div class="trend__item__pic">
                                    <img src="{{ URL::asset($item->cover_image ?? '') }}" alt="" width="100px"
                                        height="100px">
                                </div>
                                <div class="trend__item__text">
                                    <h6>{{ $item->title ?? '' }}</h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="product__price">&#8377; {{ $item->inventory->price ?? '' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="trend__content">
                        <div class="section-title">
                            <h4>Feature</h4>
                        </div>
                        @foreach ($feature ?? [] as $key => $item)
                            <div class="trend__item">
                                <div class="trend__item__pic">
                                    <img src="{{ URL::asset($item->cover_image ?? '') }}" alt="" width="100px"
                                        height="100px">
                                </div>
                                <div class="trend__item__text">
                                    <h6>{{ $item->title ?? '' }}</h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="product__price">&#8377; {{ $item->inventory->price ?? '' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Trend Section End -->

    <!-- Discount Section Begin -->
    <section class="discount">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="discount__pic">
                        <img src="{{ URL::asset('/img/discount.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="discount__text">
                        <div class="discount__text__title">
                            <span>Discount</span>
                            <h2>Summer 2019</h2>
                            <h5><span>Sale</span> 50%</h5>
                        </div>
                        <div class="discount__countdown" id="countdown-time">
                            <div class="countdown__item">
                                <span>22</span>
                                <p>Days</p>
                            </div>
                            <div class="countdown__item">
                                <span>18</span>
                                <p>Hour</p>
                            </div>
                            <div class="countdown__item">
                                <span>46</span>
                                <p>Min</p>
                            </div>
                            <div class="countdown__item">
                                <span>05</span>
                                <p>Sec</p>
                            </div>
                        </div>
                        <a href="#">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Discount Section End -->

    <!-- Services Section Begin -->
    <section class="services spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="services__item">
                        <i class="fa fa-car"></i>
                        <h6>Free Shipping</h6>
                        <p>For all oder over $99</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="services__item">
                        <i class="fa fa-money"></i>
                        <h6>Money Back Guarantee</h6>
                        <p>If good have Problems</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="services__item">
                        <i class="fa fa-support"></i>
                        <h6>Online Support 24/7</h6>
                        <p>Dedicated support</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="services__item">
                        <i class="fa fa-headphones"></i>
                        <h6>Payment Secure</h6>
                        <p>100% secure payment</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Section End -->
    <x-FooterImages />
    <!-- Instagram Begin -->
@endsection

@push('footer')
    {{-- <script>
            let header = document.querySelector('.header');
            // console.log(header);
            window.addEventListener('scroll', () => {
                const verticalScrollPx = window.scrollY || window.pageYOffset;

                if (verticalScrollPx < 500) {
                    header.style.backgroundColor = 'transparent';
                    header.style.height = "100px";
                    header.style.transition = "all 1s"

                } else {
                    header.style.backgroundColor = '#D46B30';
                    header.style.height = "70px";

                }
            });
        </script> --}}
@endpush
