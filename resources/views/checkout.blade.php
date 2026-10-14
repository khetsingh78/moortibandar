@extends('partial/layouts')
@section('title', 'Checkout | Moorti Jeevan')
@section('robots', 'noindex, nofollow')

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
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6 class="coupon__link"><span class="icon_tag_alt"></span> <a href="#">Have a coupon?</a> Click
                        here to enter your code.</h6>
                </div>
            </div>
            <form id="checkout_form" class="checkout__form">
                <div class="row">
                    <div class="col-lg-8">
                        <h5>Billing detail</h5>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Name <span>*</span></p>
                                    <input type="text" name="name" value="{{ $user->name ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Country <span>*</span></p>
                                    <input type="text" name="countory" value="{{ $user->usermeta->country ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Country/State <span>*</span></p>
                                    <input type="text" name="state" value="{{ $user->usermeta->state ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Town/City <span>*</span></p>
                                    <input type="text" name="city" value="{{ $user->usermeta->city ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Postcode/Zip <span>*</span></p>
                                    <input type="text" name="pincode" value="{{ $user->usermeta->pincode ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Address <span>*</span></p>
                                    <input type="text" placeholder="Street Address" name="street"
                                        value="{{ $user->usermeta->street ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>House/Apartment No. <span>*</span></p>
                                    <input type="text" name="house_no"
                                        placeholder="Apartment. suite, unite ect ( optinal )"
                                        value="{{ $user->usermeta->house_no ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Order notes for delivery<span>*</span></p>
                                    <input type="text" name="delivery_note"
                                        placeholder="Note about your order, special for delivery">
                                </div>
                            </div>

                            @if (!Auth::check())
                                <div class="col-lg-12">
                                    <div class="checkout__form__checkbox">
                                        <label for="acc">
                                            Create an acount?
                                            <input type="checkbox" id="acc" name="create_account_check">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p> Enter your information below to sign up. Already have an account?
                                            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                                                Login here
                                            </a>.
                                        </p>
                                    </div>
                                    <div class="checkout__form__input">
                                        <p>Name <span>*</span></p>
                                        <input type="text" name="name" placeholder="Enter Name" value="">
                                    </div>
                                    <div class="checkout__form__input">
                                        <p>Email <span>*</span></p>
                                        <input type="text" placeholder="Enter Email" name="email" value="">
                                    </div>
                                    {{-- <div class="checkout__form__input">
                                        <p>Phone <span>*</span></p>
                                        <input type="text" name="phone_no" placeholder="Enter Phone no."
                                            value="{{ $user->phone ?? '' }}">
                                    </div> --}}
                                    <div class="checkout__form__input">
                                        <p>Account Password <span>*</span></p>
                                        <input type="text" placeholder="Enter password" name="password">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout__order">
                            <h5>Your order</h5>
                            <div class="checkout__order__product">
                                <ul>
                                    <li>
                                        <span class="top__text">Product</span>
                                        <span class="top__text__right">Total</span>
                                    </li>
                                    @php
                                        $index = 0;
                                    @endphp
                                    @foreach ($cart['content'] ?? [] as $key => $item)
                                        @php
                                            $index++;
                                        @endphp
                                        <li>{{ $index }}. {{ $item->name ?? '' }} <span>&#8377
                                                {{ $item->price ?? '' }}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="checkout__order__total">
                                <ul>
                                    <li>Price <span>&#8377 {{ $cart['price'] }}</span></li>
                                    <li>Discount <span>- &#8377 {{ $cart['discount'] }}</span></li>
                                    <li>Coupon <span>- &#8377 {{ $cart['coupon'] }}</span></li>
                                    <li>GST <span>+ &#8377 {{ $cart['gst'] }}</span></li>
                                    <li>Total <span>&#8377 {{ $cart['final_total'] }}</span></li>
                                </ul>
                            </div>
                            <div class="checkout__order__widget">
                                <label for="check-payment">
                                    Case On Delivery
                                    <input type="radio" id="check-payment" value="cod" name="payment_type">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="paypal">
                                    Online
                                    <input type="radio" id="paypal" value="online" name="payment_type">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="button" class="site-btn" id="rzp-button">Place oder</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout Section End -->

    <!-- Instagram Begin -->
    {{-- <x-FooterImages /> --}}

    <!-- Instagram End -->


@endsection

@push('footer')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        let homeroute = "{{ route('home') }}";
        document.getElementById('rzp-button').onclick = async function(e) {
            e.preventDefault();
            let form = document.getElementById("checkout_form");
            let formData = new FormData(form);
            // Step 1: create order from backend
            let response = await fetch("{{ route('checkout.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            let order = await response.json();
            console.log(order);

            if (order.status == "error") {
                sweet(order.status, order.message);
                return false;
            }

            if (order.payment_method == 'online') {
                // Step 2: Open Razorpay popup
                var options = {
                    "key": order.key,
                    "amount": order.amount,
                    "currency": order.currency,
                    "name": "My Shop",
                    "description": "Order Payment",
                    "order_id": order.order_id,
                    "handler": function(res) {
                        // Step 3: Send to backend for verification
                        fetch("{{ route('payment.success') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                        .content
                                },
                                body: JSON.stringify(res)
                            })
                            .then(res => res.json())
                            .then((data) => {
                                if (data.status == "success") {
                                    // alert(data.message);
                                    sweet(data.status, data.message);
                                    window.location.href = homeroute;

                                } else {
                                    // alert(data.message);
                                    sweet(data.status, data.message);
                                }
                            });
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            } else {
                // alert(order.message);
                sweet(order.status, order.message);
                window.location.href = homeroute;
            }
        }
    </script>
@endpush
