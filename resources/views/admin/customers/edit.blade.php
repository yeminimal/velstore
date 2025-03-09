@extends('admin.layouts.admin')

@section('content')
<div class="container">

    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6>Edit Customer</h6>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ $customer->first_name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ $customer->last_name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $customer->email }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Profile Image</label>
                    <input type="file" name="profile_image" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Update Customer</button>
            </form>
        </div>
    </div>

</div>
@endsection
