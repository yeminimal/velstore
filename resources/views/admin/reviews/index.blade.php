{{--
@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header  card-header-bg text-white">
            <h6>Product Reviews</h6>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table  id="reviews-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $review->customer->first_name }} {{ $review->customer->last_name }}</td>
                            <td>{{ $review->product->title }}</td>
                            <td>{{ $review->rating }} / 5</td>
                            <td>
                                @if($review->is_approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection

--}}


@extends('admin.layouts.admin')

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endsection

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header card-header-bg text-white">
            <h6>Product Reviews</h6>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table id="reviews-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$('#reviews-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('admin.reviews.data') }}",
        type: "GET" // Fix for 405 error
    },
    columns: [
        { data: 'id', name: 'id' },
        { data: 'product_name', name: 'product_name' },
        { data: 'customer_name', name: 'customer_name' },
        { data: 'rating', name: 'rating' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ]
});

</script>
@endsection
