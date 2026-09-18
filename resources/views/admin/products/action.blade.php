<div class="d-flex gap-1 justify-content-center">

    {{-- Show --}}
    {{-- <a href="{{ route('coupons.show', $id) }}" class="btn btn-sm btn-info" title="View">
        <i class="fas fa-eye"></i>
    </a> --}}

    {{-- Edit --}}
    <a href="{{ route('products.show', $id) }}" class="btn btn-sm btn-success" title="Edit">
        <i class="fa-solid fa-eye"></i>
    </a>
    <a href="{{ route('products.edit', $id) }}" class="btn btn-sm btn-success" title="Edit">
        <i class="fas fa-edit"></i>
    </a>

    {{-- Delete --}}
    <form action="{{ route('products.destroy', $id) }}" method="POST" class="d-inline" {{--  onsubmit="return confirm('Are you sure you want to delete this category?');" --}}>

        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-sm btn-primary" title="Delete">
            <i class="fas fa-trash"></i>
        </button>
    </form>

</div>

{{-- <a class="btn btn-sm btn-success" href="{{ route('admin.viewProduct', ['productId' => $item['id']]) }}">View</a>

<a class="btn btn-sm btn-success" href="{{ route('admin.editProduct', ['productId' => $item['id']]) }}">Edit</a>

<a class="btn btn-sm btn-primary" href="{{ route('admin.deleteProduct', ['productId' => $item['id']]) }}">Delete</a> --}}
