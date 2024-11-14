@extends('admin/comman/layout')
@section('title', 'Admin panel')

@push('header')
    <style>

    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />

    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
@endpush


@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">All product's</h6>
                <a href="">Show All</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">SNO</th>
                            <th scope="col">SUN</th>
                            <th scope="col">Category</th>
                            <th scope="col">Sub Category</th>
                            <th scope="col">Inventory</th>
                            <th scope="col">Price</th>
                            <th scope="col">SGST</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item['SKU'] }}</td>
                                <td>{{ $item['parentcategory'] ? $item['parentcategory']['name'] : '' }}</td>
                                <td>{{ $item['childcategory'] ? $item['childcategory']['name'] : '' }}</td>
                                <td>{{ $item['inventory'] ? $item['inventory']['quantity'] : '' }}</td>
                                <td>{{ $item['inventory'] ? $item['inventory']['price'] : '' }}</td>
                                <td>{{ $item['SGST'] }}</td>
                                <td>
                                    {{-- <a class="btn btn-sm btn-primary" href="{{route("admin.editProduct")}}">Detail</a> --}}
                                    <a class="btn btn-sm btn-primary" href="{{route("admin.editProduct", ['productId'=>$item['id']])}}">Edit</a>
                                    <a class="btn btn-sm btn-primary" href="">View</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->

@endsection

@push('footer')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endpush
