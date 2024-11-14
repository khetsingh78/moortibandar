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
                            <h3>Sign In</h3>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="useremail" placeholder="name@example.com" />
                            <label for="useremail">Email address</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="userpassword" placeholder="Password" />
                            <label for="userpassword">Password</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" />
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div>
                            <a href="">Forgot Password</a>
                        </div>
                        <button type="submit" id="loginRequest" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        <p class="text-center mb-0">Don't have an Account? <a href="{{ route('register') }}">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>
@endsection

@push('footer')
    <script>
        $(document).ready(function() {
            $('#loginRequest').click(function() {
                // Retrieve values from input fields
                var email = $('#useremail').val();
                var password = $('#userpassword').val();

                // Define the data to be sent in the POST request
                var postData = {
                    email: email,
                    password: password
                };

                // console.log(postData);
                // Make an AJAX request using jQuery
                $.ajax({
                    url: "{{ url('/loginRequest') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json', // Set the content type to JSON
                    data: JSON.stringify(postData), // Convert the data to JSON string
                    success: function(response) {
                        // Handle successful response here
                        console.log('Response:', response);
                        window.location.href = "{{ route('user.profile') }}";
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endpush
