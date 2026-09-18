@extends('admin/comman/layout')
@section('title', 'Admin panel')

@push('header')
    <style>

    </style>
@endpush
@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="col-sm-12 col-xl-12">

            <form action="{{ route('categories.store') }}" method="post">
                @csrf
                <div class="bg-secondary rounded h-100 p-4">

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Create Category</h6>
                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-success">Back</a>
                    </div>

                    {{-- <div class="form-floating mb-3">
                        <select class="form-select" name="type" id="floatingSelect" onchange="showHideCategories(this)"
                            aria-label="Floating label select example">
                            <option value="Select">Category Type</option>
                            <option value="parent">Parent</option>
                            <option value="child">Child</option>
                        </select>
                        <label for="floatingSelect">Category Type</label>
                    </div> --}}

                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control" id="floatingInput"
                            placeholder="Enter Name">
                        <label for="floatingInput">Enter Name</label>
                    </div>

                    <div class="form-floating mb-3" id="parent_category">
                        <select class="form-select" name="parent_category" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option value="" selected>Parent Categories</option>
                            @foreach ($categories as $key => $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Select Parent Category</label>
                    </div>



                    <div class="form-floating mb-3 ">
                        <button type="submit" class="border  btn btn-success m-2">Add</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@push('footer')
    {{-- <script>
        function showHideCategories(element) {
            // console.log($(element).val());

            if ($(element).val() === 'child') {
                $('#parent_category').show();
            } else {
                $('#parent_category').hide();
            }
        }
    </script> --}}
@endpush
