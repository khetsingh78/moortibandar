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
                        {{-- <a href="{{ route('product') }}"><i class="fa fa-home"></i> Product</a> --}}
                        <a href="{{ route('shop', ['category' => $product['category']['name']]) }}">{{ Str::ucfirst($product['category']['name'] ?? '') }}
                        </a>
                        <span>{{ Str::upper($product['title'] ?? '') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__left product__thumb nice-scroll">
                            {{-- <a class="pt active" href="#product-1">
                                <img src="{{ URL::asset('img/product/details/thumb-1.jpg') }}" alt="">
                            </a> --}}
                            @foreach ($product['images'] as $key => $images)
                                <a class="pt {{ $key == 0 ? 'active' : '' }}" href="#product-{{ $key }}">
                                    <img src="{{ asset($images['image_name']) ?? '' }}" alt="">
                                </a>
                            @endforeach

                        </div>
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                @foreach ($product['images'] as $key => $images)
                                    <img data-hash="product-{{ $key }}" class="product__big__img"
                                        src="{{ asset($images['image_name']) ?? '' }}" alt="" />
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        <h3>{{ $product['title'] ?? '' }} <span>Discover our beautiful Handcrafted stone stutue.</span></h3>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <span>( 138 reviews )</span>
                        </div>
                        <div class="product__details__price">&#8377;{{ $product['inventory']['price'] ?? '' }} <span>
                                {{ $product['discount']['dis_percent'] ?? '' }}</span></div>
                        <p>{{ $product['short_description'] ?? '' }}</p>
                        <div class="product__details__button">
                            <div class="quantity">
                                <span>Quantity:</span>
                                <div class="pro-qty">
                                    <input type="text" data-product_id="{{ $product->id ?? '' }}" {{-- data-item_price="{{ $product->price }}" --}}
                                        class="update-qty" value="1">
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="cart-btn add-to-cart"
                                data-product_id="{{ $product['id'] }}">
                                <span class="icon_bag_alt"></span> Add to cart</a>
                            <ul>
                                <li><a href="javascript:void(0)"><span class="icon_heart_alt add-to-wishlist"
                                            data-product_id="{{ $product['id'] }}"></span></a></li>
                                {{-- <li><a href="javascript:void(0)"><span class="icon_bag_alt add-to-cart"
                                            data-product_id="{{ $item['id'] }}"></span></a></li> --}}
                                <li><a href="javascript:void(0)"><span class="icon_adjust-horiz"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__details__widget">
                            <ul>
                                <li>
                                    <span>Availability:</span>
                                    <div class="stock__checkbox">
                                        <label for="stockin">
                                            In Stock
                                            <input type="checkbox" id="stockin" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Available color:</span>
                                    <div class="color__checkbox">
                                        <label for="red">
                                            <span>{{ $product['marbaltype'] ?? '' }}</span>
                                            {{-- <input type="radio" name="color__radio" id="red" checked>
                                            <span class="checkmark"></span> --}}
                                        </label>
                                        {{-- <label for="black">
                                            <input type="radio" name="color__radio" id="black">
                                            <span class="checkmark black-bg"></span>
                                        </label>
                                        <label for="grey">
                                            <input type="radio" name="color__radio" id="grey">
                                            <span class="checkmark grey-bg"></span>
                                        </label>   --}}

                                    </div>
                                </li>
                                <li>
                                    <span>Available size:</span>
                                    <div class="size__btn">
                                        <label for="xs-btn" class="active">
                                            {{-- <input type="radio" id="xs-btn"> --}}
                                            <span>{{ $product['dimension'] ?? '' }}</span>

                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Promotions:</span>
                                    <p>Free shipping</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Specification</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2 )</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <h6>Description</h6>
                                <p>{{ $product['short_description'] ?? '' }}</p>
                                <p>{{ $product['short_description'] ?? '' }}</p>

                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <h6>Specification</h6>
                                <p>{{ $product['long_description'] ?? '' }}</p>
                                <p>{{ $product['long_description'] ?? '' }}</p>
                                <p>{{ $product['long_description'] ?? '' }}</p>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <h6>Reviews ( 2 )</h6>
                                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                    quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                    Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                    voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                    consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                    consequat massa quis enim.</p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                    quis, sem.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="related__title">
                        <h5>RELATED PRODUCTS</h5>
                    </div>
                </div>
                @foreach ($relevant ?? [] as $key => $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ asset($item['cover_image']) }}">
                                <div class="label new">New</div>
                                {{-- <div class="label stockout">out of stock</div> --}}
                                <ul class="product__hover">
                                    <li><a href="{{ asset($item['cover_image'] ?? '') }}" class="image-popup"><span
                                                class="arrow_expand"></span></a></li>
                                    <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                    <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a
                                        href="{{ route('productDetails', ['slug' => $item['slug']]) }}">{{ $item['title'] ?? '' }}</a>
                                </h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price">{{ $item['inventory']['price'] ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

@endsection

@push('footer')
@endpush
