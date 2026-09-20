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

            <form action="{{ route('coupons.store') }}" method="post">
                @csrf
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">E Coupon</h6>
                        <a href="{{ route('coupons.index') }}" class="btn btn-sm btn-success">Back</a>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="title" class="form-control" id="floatingInput"
                            placeholder="Enter Title">
                        <label for="floatingInput">Title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="code" class="form-control" id="floatingInput"
                            placeholder="Enter Code">
                        <label for="floatingInput">Code</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" name="type" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option value="flat">flat</option>
                            <option selected value="percent">percent</option>
                        </select>
                        <label for="floatingSelect">Discount Type</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="value" class="form-control" id="floatingInput"
                            placeholder="Enter value">
                        <label for="floatingInput">Value</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" name="expire_at" class="form-control" id="floatingInput"
                            placeholder="Enter expire date">
                        <label for="floatingInput">Expire at</label>
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
