@extends('admin/comman/layout')
@section('title', 'Admin panel')

@push('header')
    <style>

    </style>
@endpush


@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="col-sm-12 col-xl-6">

            <form action="{{ route('admin.editCategoryRequest') }}" method="post">
                @csrf
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Edit Category</h6>
                    <div class="form-floating mb-3">

                        <input type="text" name="category" value="{{ $result['name'] }}" class="form-control"
                            id="floatingInput" placeholder="Enter Title">
                        <label for="floatingInput">Title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="description" value="{{ $result['description'] }}" class="form-control"
                            id="floatingInput" placeholder="Enter Description">
                        <label for="floatingInput">Description</label>
                    </div>
                    <div class="form-floating mb-3 ">
                        <button type="submit" class="border  btn btn-success m-2">update</button>
                    </div>
                    <input type="text" value="{{ $result['id'] }}" name="id" hidden>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('footer')
@endpush
