@extends('admin.layouts.admin')

@section('title', 'Manage Attributes')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header card-header-bg text-white">
                <h6>Manage Attributes</h6>
                <a href="{{ route('admin.attributes.create') }}" class="btn btn-success float-end">Add New Attribute</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Attribute Name</th>
                            <th>Values</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attributes as $attribute)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attribute->name }}</td>
                                <td>
                                    @foreach ($attribute->values as $value)
                                        <span class="badge bg-primary">{{ $value->value }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.attributes.edit', $attribute->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
