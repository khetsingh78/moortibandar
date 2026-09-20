@extends('partial/layouts')
@section('title', 'Whishlist')

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
                        <span>Whishlist Items</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <div class="container">

            @if ($data && count($data['data']) > 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shop__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        {{-- <th>Total</th>  --}}
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['data'] ?? [] as $item)
                                        <tr>
                                            <td class="cart__product__item">
                                                <img src="{{ $item->attributes->image ?? 'N/A' }}" alt=""
                                                    style="width: 100px;">
                                                <div class="cart__product__item__title">
                                                    <h6>{{ $item->name ?? 'N/A' }}</h6>
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__price">&#8377; {{ $item->price ?? 00 }}</td>
                                            <td class="cart__quantity">
                                                <div class="pro-qty pro-qty-wishlist">
                                                    <input type="text" value="{{ $item->quantity ?? 0 }}">
                                                </div>
                                            </td>
                                            {{-- <td class="cart__total">$ {{ $item->subtotal ?? 00.0 }}</td> --}}
                                            <td class="cart__close"><span class="icon_close remove-to-wishlist"
                                                    data-product_id="{{ $item->id }}"></span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="row m-5">
                    <div class="col-lg-12">
                        <h1 class="text-center">Item Not Found.</h1>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="{{ route('shop', 'all-product') }}">Continue Shopping</a>
                    </div>
                </div>
                @if ($data['count'] > 0)
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="cart__btn update__btn">
                            <a href="{{ route('cart.index', ['cart' => true]) }}"><span class=""></span>Continew To
                                Cart</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Shop Cart Section End -->

    <!-- Instagram Begin -->
    <x-FooterImages />

    <!-- Instagram End -->

@endsection

@push('footer')
@endpush
