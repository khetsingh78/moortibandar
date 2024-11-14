@extends('admin/comman/layout')
@section('title', 'Admin panel')

@push('header')
    <style>

    </style>
@endpush


@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="col-sm-12 col-xl-6">

            <form action="{{ route('admin.addCategory') }}" method="post">
                @csrf
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Add New Category</h6>
                    <div class="form-floating mb-3">
                        <input type="text" name="category" class="form-control" id="floatingInput"
                            placeholder="Enter Title">
                        <label for="floatingInput">Title</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="description" class="form-control" id="floatingInput"
                            placeholder="Enter Description">
                        <label for="floatingInput">Description</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="type" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option value="parent">parent</option>
                            <option selected value="child">child</option>
                        </select>
                        <label for="floatingSelect">Category Type</label>
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
@endpush
