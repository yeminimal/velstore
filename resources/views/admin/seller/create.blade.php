@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h2>Add Seller</h2>
    <form action="{{ route('admin.sellers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label>Store Name</label>
            <input type="text" name="store_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Store Logo</label>
            <input type="file" name="logo" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
