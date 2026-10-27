<div class="d-flex gap-1 justify-content-center">

    {{-- Show --}}
    <a href="{{ route('orders.show', $id) }}" class="btn btn-sm btn-info" title="View">
        <i class="fas fa-eye"></i>
    </a>

    <a href="{{ route('orders.show', $id) }}#shipment-panel" class="btn btn-sm btn-warning" title="Create or view shipment">
        <i class="fas fa-truck-fast"></i>
    </a>

    {{-- Edit --}}
    {{-- <a href="{{ route('orders.edit', $id) }}" class="btn btn-sm btn-info" title="Edit">
        <i class="fas fa-edit"></i>
    </a> --}}

    {{-- Delete --}}
    {{-- <form action="{{ route('orders.destroy', $id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
            <i class="fas fa-trash"></i>
        </button>
    </form> --}}

</div>
