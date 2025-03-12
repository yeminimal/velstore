@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Seller</h2>
    <form action="{{ route('admin.sellers.update', $seller->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $seller->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $seller->email }}" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $seller->phone }}">
        </div>

        <div class="mb-3">
            <label>Store Name</label>
            <input type="text" name="store_name" class="form-control" value="{{ $seller->store_name }}" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ $seller->address }}</textarea>
        </div>

        <div class="mb-3">
            <label>Store Logo</label>
            <input type="file" name="logo" class="form-control">
            @if($seller->logo)
                <img src="{{ asset('storage/' . $seller->logo) }}" alt="Seller Logo" width="100" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="pending" {{ $seller->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $seller->status == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $seller->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
