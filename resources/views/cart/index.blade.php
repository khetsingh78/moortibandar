@extends('partial/layouts')
@section('title', 'cart')

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
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart ?? [] as $item)
                                    <tr class="cart_list_item">
                                        <td class="cart__product__item">
                                            <img src="{{ $item->attributes->image ?? '' }}" alt=""
                                                style="width: 100; height:100px">
                                            <div class="cart__product__item__title">
                                                <h6>{{ $item->name ?? '' }}</h6>
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cart__price">&#8377; <span>{{ $item->price ?? 00 }}</span> </td>
                                        <td class="cart__quantity">
                                            <div class="pro-qty">
                                                <input type="text" data-product_id="{{ $item->id ?? '' }}"
                                                    data-item_price="{{ $item->price }}" class="update-qty"
                                                    value="{{ $item->quantity ?? 0 }}">
                                            </div>
                                        </td>
                                        <td class="cart__price">&#8377; <span>{{ $item->getPriceSum() ?? '' }}</span> </td>

                                        <td class="cart__close"><span class="icon_close remove-to-cart"
                                                data-product_id="{{ $item->id ?? '' }}"></span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="{{ route('shop', 'all-product') }}">Continue Shopping</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn">
                        <a href="#"><span class="icon_loading"></span> Update cart</a>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="col-lg-6">
                    <div class="discount__content">
                        <h6>Discount codes</h6>
                        <form action="{{ route('apply-coupon') }}" method="post" class="apply-coupon">
                            <input type="text" placeholder="Enter coupon code" name="coupon"
                                value="{{ Session::get('coupon') ?? '' }}">

                            <button type="button" class="site-btn {{ Session::get('coupon') ? '' : 'd-none' }}"
                                id="remove_coupon">Remove</button>
                            <button type="submit" class="site-btn {{ Session::get('coupon') ? 'd-none' : '' }}"
                                id="apply_coupon">Apply</button>

                        </form>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Cart total</h6>
                        <ul>
                            {{-- <li>Total Amount <span>&#8377; {{ CartFacade::getSubTotalWithoutConditions() ?? 00 }}</span>
                            </li>
                            <li>Discount <span>
                                    &#8377;{{ CartFacade::getSubTotalWithoutConditions() - Cart::getTotal() }}</span>
                            </li>
                            <li>coupon <span>
                                    &#8377;{{ CartFacade::getSubTotalWithoutConditions() - Cart::getTotal() }}</span>
                            </li>
                            <li>GST <span>&#8377; {{ CartFacade::getTotal() - CartFacade::getSubTotal() }}</span></li>
                            <li>Subtotal <span> &#8377;{{ CartFacade::getTotal() ?? 00 }}</span></li>
                            <li>Total<span> &#8377; {{ CartFacade::getSubTotal() ?? 00 }}</span></li> --}}

                            <li>Total Amount
                                <span> &#8377; <span class="price">
                                        {{ $summary['price'] ?? 00 }}</span></span>
                            </li>
                            <li>Discount <span>&#8377; <span class="discount">
                                        {{ $summary['discount'] ?? 00 }}</span></span>
                            </li>
                            @if (Session::has('coupon'))
                                <li>coupon <span>&#8377; <span class="coupon">
                                            {{ $summary['coupon'] ?? 00 }}</span></span>
                                </li>
                            @endif
                            <li>GST <span>&#8377; <span class="gst">
                                        {{ $summary['gst'] ?? 00 }}</span></span>
                            </li>
                            <li>Final Amount <span>&#8377; <span class="final_total">
                                        {{ $summary['final_total'] ?? 00 }}</span></span>
                            </li>

                        </ul>
                        <a href="{{ route('checkout.index') }}" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
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
