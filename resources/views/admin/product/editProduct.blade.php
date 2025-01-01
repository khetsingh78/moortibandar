@extends('admin/comman/layout')
@section('title', 'Admin panel')

@push('header')
    <style>

    </style>
@endpush


@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="col-sm-12 col-xl-12">

            <div class="bg-secondary rounded h-100 p-4">
                <form action="{{ route('admin.editProductRequest') }}" method="post">
                    @csrf
                    <input type="text" name="updateType" value="productDetails" id="" hidden />
                    <input type="text" name="productId" value="{{ $products['id'] }}" id="" hidden />

                    <h6 class="mb-4">Edit Product Details</h6>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{ $products['title'] }}" name="heading"
                            id="floatingInput" placeholder="Enter Product Heading" />
                        <label for="floatingInput">Enter Heading</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{ $products['short_description'] }}"
                            name="sortdescription" id="floatingInput" placeholder="Enter Product Heading" />
                        <label for="floatingInput">Enter Short Description</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{ $products['long_description'] }}"
                            name="longdescription" id="floatingInput" placeholder="Enter Product Heading" />
                        <label for="floatingInput">Enter Long Description</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" name="category" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $products['category']['id'] }}">{{ $products['category']['name'] }}
                            </option>
                            @foreach ($category as $key => $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Select Category</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="discount" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $products['discount']['id'] }}">
                                {{ $products['discount']['dis_percent'] }}</option>
                            @foreach ($discount as $key => $item)
                                <option value="{{ $item['id'] }}">{{ $item['dis_percent'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Discount</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="sgst" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $products['sgst']['id'] }}">
                                {{ $products['sgst']['gst'] }}</option>
                            @foreach ($gst as $key => $item)
                                <option value="{{ $item['id'] }}">{{ $item['gst'] }}</option>
                            @endforeach

                        </select>
                        <label for="floatingSelect">SGST</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="cgst" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $products['cgst']['id'] }}">
                                {{ $products['cgst']['gst'] }}</option>
                            @foreach ($gst as $key => $item)
                                <option value="{{ $item['id'] }}">{{ $item['gst'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">CGST</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="height" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $products['height'] }}">
                                {{ $products['height'] }}</option>
                            @foreach (height() as $key => $item)
                                <option> {{ $item['name'] }}</option>
                            @endforeach

                        </select>
                        <label for="floatingSelect">Choose Height</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="dimension" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $products['dimension'] }}">
                                {{ $products['dimension'] }}</option>
                            @foreach (dimension() as $key => $item)
                                <option> {{ $item['name'] }}</option>
                            @endforeach

                        </select>
                        <label for="floatingSelect">Choose Dimension</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="marbaltype" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $products['marbaltype'] }}">
                                {{ $products['marbaltype'] }}</option>
                            @foreach (marbal() as $key => $item)
                                <option> {{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Choose Marbal</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="paintingtype" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $products['paintingtype'] }}">
                                {{ $products['paintingtype'] }}</option>
                            @foreach (painting() as $key => $item)
                                <option> {{ $item['name'] }}</option>
                            @endforeach

                        </select>
                        <label for="floatingSelect">Choose Painting </label>
                    </div>
                    <div class="form-floating mb-3 ">
                        <button type="submit" class="border  btn btn-success m-2">Save Details</button>
                    </div>
                </form>
            </div>

            <div class="bg-secondary rounded h-100 p-4 my-2">
                <h6 class="mb-4">Edit Inventory Of Product</h6>
                <form action="{{ route('admin.editProductRequest') }}" method="post">
                    @csrf
                    <input type="text" name="updateType" value="inventory" id="" hidden />
                    <input type="text" name="productId" value="{{ $products['id'] }}" id="" hidden />

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{ $products['inventory']['quantity'] }}"
                            name="quantity" id="floatingInput" placeholder="Enter Product Quantity" />
                        <label for="floatingInput">Enter Quantity</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" value="{{ $products['inventory']['price'] }}"
                            name="price" id="floatingInput" placeholder="Enter Product Price" />
                        <label for="floatingInput">Enter Price</label>
                    </div>
                    <div class="form-floating mb-3 ">
                        <button type="submit" class="border  btn btn-success m-2">Update Inventory</button>
                    </div>
                </form>
            </div>


            <div class="bg-secondary rounded h-100 p-4 my-2">
                <h6 class="mb-4">Edit Product Cover Image</h6>
                <form action="{{ route('admin.editProductRequest') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="updateType" value="coverImage" id="" hidden />
                    <input type="text" name="productId" value="{{ $products['id'] }}" id="" hidden />

                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="file" name="coverimageurl" class="form-control" id="floatingInput"
                                    placeholder="Enter Product Heading">
                                <label for="floatingInput">Cover Image Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="coverimagealt" value="{{ $products['alt_image'] }}"
                                    class="form-control" id="floatingInput" placeholder="Enter Product Heading">
                                <label for="floatingInput">Cover Image Alt Tag</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <img src="{{ URL::asset('public/storage/' . $products['cover_image']) }}"
                                alt="{{ $products['alt_image'] }}" srcset="" style="height: 200px; width:400px">
                        </div>
                    </div>
                    <div class="form-floating mb-3 ">
                        <button type="submit" class="border  btn btn-success m-2">Update Cover Image</button>
                    </div>
                </form>
            </diV>

            <div class="bg-secondary rounded h-100 p-4 my-2">
                <h6 class="mb-4">Edit Product Featured Image</h6>
                <form action="{{ route('admin.editProductRequest') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="updateType" value="featuredImage" id="" hidden />
                    <div class="form-floating mb-3">
                        <input type="file" name="allImagesOfProduct[]" class="form-control" id="floatingInput"
                            placeholder="Enter Product Heading" multiple>
                        <label for="floatingInput">All Product Image Seperate By Comma</label>
                    </div>
                    <div class="form-floating mb-3 ">
                        <button type="submit" class="border  btn btn-success m-2">Update Featured Images</button>
                    </div>
                </form>
                <div class="row">
                    @foreach ($products->images as $key => $item)
                    <div class="col-3">
                        <img src="{{ URL::asset('public/storage/' . $item['image_name']) }}"
                        alt="{{ $products['alt_image'] }}" srcset="" style="height: 200px; width: 200px" />
                    </div>
                    @endforeach

                </div>
            </div>


        </div>
    </div>

@endsection

@push('footer')
@endpush
