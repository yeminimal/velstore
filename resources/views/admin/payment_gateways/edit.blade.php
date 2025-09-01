@extends('admin.layouts.admin')

@section('content')
<div class="container">
  <h2 class="mb-4">Edit Payment Gateway</h2>
  
    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Form --}}
    <form action="{{ route('admin.payment-gateways.update', $paymentGateway->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Gateway Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $paymentGateway->name) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="code" class="form-label">Code (unique)</label>
        <input type="text" name="code" id="code" value="{{ old('code', $paymentGateway->code) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description', $paymentGateway->description) }}</textarea>
    </div>

    <div class="form-check mb-3">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ $paymentGateway->is_active ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
</div>
@endsection
