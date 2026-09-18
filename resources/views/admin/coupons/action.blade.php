<div class="d-flex gap-1 justify-content-center">

    {{-- Show --}}
    {{-- <a href="{{ route('coupons.show', $id) }}" class="btn btn-sm btn-info" title="View">
        <i class="fas fa-eye"></i>
    </a> --}}

    {{-- Edit --}}
    <a href="{{ route('coupons.edit', $id) }}" class="btn btn-sm btn-primary" title="Edit">
        <i class="fas fa-edit"></i>
    </a>

    {{-- Delete --}}
    <form action="{{ route('coupons.destroy', $id) }}" method="POST" class="d-inline"
       {{--  onsubmit="return confirm('Are you sure you want to delete this category?');" --}}>

        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
            <i class="fas fa-trash"></i>
        </button>
    </form>

</div>
