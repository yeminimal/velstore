@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h2>All Sellers</h2>
    <a href="{{ route('admin.sellers.create') }}" class="btn btn-primary mb-3">Add New Seller</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Store</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $seller)
            <tr>
                <td>{{ $seller->name }}</td>
                <td>{{ $seller->store_name }}</td>
                <td>{{ $seller->email }}</td>
                <td>{{ ucfirst($seller->status) }}</td>
                <td>
                    <a href="{{ route('admin.sellers.edit', $seller->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.sellers.destroy', $seller->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sellers->links() }}
</div>
@endsection
