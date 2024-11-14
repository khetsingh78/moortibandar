@extends('admin/comman/layout')
@section('title', 'Admin panel')

@push('header')
    <style>

    </style>
@endpush


@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="col-sm-12 col-xl-12">
            <form action="{{ route('admin.editProductRequest') }}" method="post">
                @csrf
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Edit Product Details</h6>
                    <div class="form-floating mb-3">
                        <input type="text" value="{{ $result['title'] }}" class="form-control" name="heading"
                            id="floatingInput" placeholder="Enter Product Heading" />
                        <label for="floatingInput">Enter Heading</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="{{ $result['inventory']['quantity'] }}" class="form-control"
                            name="quantity" id="floatingInput" placeholder="Enter Product Quantity" />
                        <label for="floatingInput">Enter Quantity</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="{{ $result['inventory']['price'] }}" class="form-control"
                            name="price" id="floatingInput" placeholder="Enter Product Quantity" />
                        <label for="floatingInput">Enter price</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="{{ $result['short_description'] }}" class="form-control"
                            name="sortdescription" id="floatingInput" placeholder="Enter Product Heading" />
                        <label for="floatingInput">Enter Short Description</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="{{ $result['long_description'] }}" class="form-control"
                            name="longdescription" id="floatingInput" placeholder="Enter Product Heading" />
                        <label for="floatingInput">Enter Long Description</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="parentcategory" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $result['parentcategory']['id'] }}">
                                {{ $result['parentcategory']['name'] }}</option>
                            @foreach ($category as $key => $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach

                        </select>
                        <label for="floatingSelect">Parent Category</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="childcategory" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $result['childcategory']['id'] }}">
                                {{ $result['childcategory']['name'] }}</option>
                            @foreach ($category as $key => $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Child Category</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="discount" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $result['discount']['id'] }}">
                                {{ $result['discount']['name'] }}</option>
                            @foreach ($discount as $key => $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Discount</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="sgst" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $result['SGST'] }}">{{ $result['SGST'] }}</option>

                        </select>
                        <label for="floatingSelect">SGST</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="cgst" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected value="{{ $result['CGST'] }}">{{ $result['CGST'] }}</option>

                        </select>
                        <label for="floatingSelect">CGST</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="height" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected {{ $result['height'] }}> {{ $result['height'] }} </option>
                            <option> 6 inch </option>
                            <option> 9 inch </option>
                            <option> 12 inch </option>
                            <option> 16 inch </option>
                            <option> 21 inch </option>
                            <option> 26 inch </option>
                            <option> 32 inch </option>
                        </select>
                        <label for="floatingSelect">Choose Height</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="dimension" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected {{ $result['dimension'] }}> {{ $result['dimension'] }} </option>
                            <option> 9 x 4 Inches </option>
                            <option> 18 x 8 Inches</option>
                            <option> 32 x 10 Inches </option>
                            <option> 21 x 9 Inches </option>
                        </select>
                        <label for="floatingSelect">Choose Dimension</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="marbaltype" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected {{ $result['marbaltype'] }}> {{ $result['marbaltype'] }} </option>
                            <option> Pure White </option>
                            <option> Pure Black </option>
                            <option> Pure Red </option>
                            <option> Pure Green </option>
                        </select>
                        <label for="floatingSelect">Choose Marbal</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="paintingtype" id="floatingSelect"
                            aria-label="Floating label select example">
                            <option selected {{ $result['paintingtype'] }}> {{ $result['paintingtype'] }} </option>
                            <option> Elegant Gold </option>

                        </select>
                        <label for="floatingSelect">Choose Painting </label>
                    </div>
                    {{-- <div class="form-floating mb-3">
                        <input type="file" name="coverimageurl" class="form-control" id="floatingInput"
                            placeholder="Enter Product Heading">
                        <label for="floatingInput">Cover Image Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="coverimagealt" class="form-control" id="floatingInput"
                            placeholder="Enter Product Heading">
                        <label for="floatingInput">Cover Image Alt Tag</label>
                    </div> --}}
                    {{-- <div class="form-floating mb-3">
                        <input type="file" name="allImagesOfProduct[]"  class="form-control" id="floatingInput"
                            placeholder="Enter Product Heading" multiple>
                        <label for="floatingInput">All Product Image Seperate By Comma</label>
                    </div> --}}
                    {{-- <div class="mb-3">
                    <label for="formFileLg" class="form-label">Product Cover Imgage</label>
                    <input class="form-control form-control-lg bg-dark" id="formFileLg" type="file">
                </div>
                <div class="mb-3">
                    <label for="formFileLg" class="form-label">Product All Images</label>
                    <input class="form-control form-control-lg bg-dark" id="formFileLg" type="file" multiple>
                </div> --}}

                    <input type="text" value="{{ $result['id'] }}" name="id" hidden>
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
