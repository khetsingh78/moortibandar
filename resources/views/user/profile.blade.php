@extends('partial/layouts')
{{-- @section('title', 'Moorti store') --}}

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
                        <a href="{{ route('user.profile') }}">My Account </a>

                        <span>{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <section class="section_profile">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h3>Name:- {{ Auth::user()->name }}</h3>
                    <h3>Email:- {{ Auth::user()->email }}</h3>

                </div>
                <div class="col-4">

                    <div class="user-profile" style="height: 400px">

                        <img src="{{ URL::asset('public/storage/' . Auth::user()->profile_url) }}" alt="user profile page"
                            srcset="" style="height: 200px" />

                        <form action="{{ route('user.photo') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="file" name="userPhoto" class="form-control" id="userprofile">
                                <label class="input-group-text" for="userprofile">Upload</label>
                            </div>
                            <button type="submit">Upload</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('footer')
    {{-- <script>
        console.log("This is the footer");
    </script> --}}
@endpush
