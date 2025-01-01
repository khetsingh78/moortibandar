@extends('admin/comman/layout')
@section('title', 'Admin panel')

@push('header')
    <style>

    </style>
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
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">SNO</th>
                            <th scope="col">Title</th>
                            <th scope="col">Type</th>
                            <th scope="col">Created</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categoryList as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['parent_id']? "Child":"Parent" }}</td>
                                <td>{{ $item['created_at'] }}</td>

                                <td>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('admin.editCategory', ['category' => $item['id']]) }}">Edit</a>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('admin.editCategory', ['category' => $item['id']]) }}">View</a>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('admin.deleteCategory', ['category' => $item['id']]) }}">Delete</a>
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
@endpush
