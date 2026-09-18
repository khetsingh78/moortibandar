@extends('admin/comman/layout')
@section('title', 'Admin panel')

@push('header')
    <style>

    </style>
@endpush


@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="col-sm-12 col-xl-12">


            <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Add Product</h6>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-success">Back</a>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="heading" value="{{ old('heading') }}"
                            id="floatingInput" placeholder="Enter Product Heading" />
                        <label for="floatingInput">Enter Heading</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="quantity" value="{{ old('quantity') }}"
                            id="floatingInput" placeholder="Enter Product Quantity" />
                        <label for="floatingInput">Enter Quantity</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="price" value="{{ old('price') }}"
                            id="floatingInput" placeholder="Enter Product Quantity" />
                        <label for="floatingInput">Enter Price</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="sortdescription"
                            value="{{ old('sortdescription') }}" id="floatingInput" placeholder="Enter Product Heading" />
                        <label for="floatingInput">Enter Short Description</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="longdescription"
                            value="{{ old('longdescription') }}" id="floatingInput" placeholder="Enter Product Heading" />
                        <label for="floatingInput">Enter Long Description</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="category" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="">Select Category</option>
                            @foreach ($category as $key => $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Select Category</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="discount_type">
                            <option value="percent">
                                Percent
                            </option>
                            <option value="flat">
                                Flat
                            </option>
                        </select>
                        <label for="floatingSelect">Discount Type</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="discount_value" value="{{ old('discount_value') }}" class="form-control"
                            id="floatingInput" placeholder="Enter value">
                        <label for="floatingInput">Discount value</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="gsttax" value="{{ old('gsttax') }}" class="form-control"
                            id="floatingInput" placeholder="Enter GST">
                        <label for="floatingInput">GST Tax</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" name="height" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value=""> Choose Height </option>
                            @foreach (height() as $key => $item)
                                <option> {{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Choose Height</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="dimension" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value=""> Choose Dimension </option>
                            @foreach (dimension() as $key => $item)
                                <option> {{ $item['name'] }}</option>
                            @endforeach

                        </select>
                        <label for="floatingSelect">Choose Dimension</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="marbaltype" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value=""> Choose Marbal </option>
                            @foreach (marbal() as $key => $item)
                                <option> {{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Choose Marbal</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="paintingtype" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value=""> Choose Painting </option>
                            @foreach (painting() as $key => $item)
                                <option> {{ $item['name'] }}</option>
                            @endforeach

                        </select>
                        <label for="floatingSelect">Choose Painting </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" name="coverimageurl" class="form-control" id="floatingInput"
                            placeholder="Enter Product Heading">
                        <label for="floatingInput">Cover Image Name</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="coverimagealt" class="form-control" id="floatingInput"
                            placeholder="Enter Product Heading">
                        <label for="floatingInput">Cover Image Alt Tag</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="file" name="allImagesOfProduct[]" class="form-control" id="floatingInput"
                            placeholder="Enter Product Heading" multiple>
                        <label for="floatingInput">All Product Image Seperate By Comma</label>
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
