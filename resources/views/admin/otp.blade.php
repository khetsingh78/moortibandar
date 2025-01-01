@extends('admin/comman/signLayout')

@push('header')
    <style>

    </style>
@endpush


@section('content')
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="{{ route('home') }}" class="">
                                <h3 class="text-primary">Back Home</h3>
                            </a>
                            <h3>Verify OTP</h3>
                        </div>

                        <form action="{{ route('VerifyOtp') }}" method="post">
                            <div style="color:red; py-2">
                                @if (Session::has('ErrorMessage'))
                                    <p style=""> {{ Session::get('ErrorMessage') }} </p>
                                @endif
                            </div>
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" name="email" value="{{ $Email }}" class="form-control"
                                id="useremail" disabled />
                                <label for="useremail" style="color:green">We have sent otp to this email...</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="otp" class="form-control" id="userpassword"
                                    placeholder="Enter OTP" />
                                <label for="userpassword">Enter OTP</label>
                            </div>
                            <div  class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    {{-- <input type="checkbox" class="form-check-input" id="exampleCheck1" /> --}}
                                    {{-- <label class="form-check-label" for="exampleCheck1">Check me out</label> --}}
                                </div>
                                <a href="">Resend OTP</a>
                            </div>
                            <button type="submit" id="" class="btn btn-primary py-3 w-100 mb-4">Verify
                                OTP</button>
                            {{-- <p class="text-center mb-0">Don't have an Account? <a href="{{ route('register') }}">Sign Up</a> --}}
                            </p>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>
@endsection
