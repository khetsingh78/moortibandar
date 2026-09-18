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

            <form action="{{ route('categories.update', $category->id) }}" method="post">
                @csrf
                @method('put')
                <div class="bg-secondary rounded h-100 p-4">

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Edit Category</h6>
                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-success">Back</a>
                    </div>



                    <div class="form-floating mb-3">
                        <input type="text" name="name" value="{{ $category->name ?? '' }}" class="form-control"
                            id="floatingInput" placeholder="Enter Name">
                        <label for="floatingInput">Enter Name</label>
                    </div>

                    <div class="form-floating mb-3" id="parent_category">
                        <select class="form-select" name="parent_category" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option value="">Parent Categories</option>
                            @foreach ($categories as $key => $item)
                                <option value="{{ $item['id'] }}"
                                    {{ $category->parent_id == $item['parent_id'] ? 'selected' : '' }}>
                                    {{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Select Parent Category</label>
                    </div>

                    <div class="form-floating mb-3 ">
                        <button type="submit" class="border  btn btn-success m-2">Update</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@push('footer')
@endpush
