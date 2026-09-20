@extends('admin/comman/layout')
@section('title', 'Admin panel')

@push('header')
    <style>

    </style>
@endpush
@section('content')
    {{-- @dd($dataTable->table()); --}}
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Recent Sale</h6>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-success">Back</a>
            </div>
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->

@endsection
@push('footer')
    {{ $dataTable->scripts() }}
@endpush
