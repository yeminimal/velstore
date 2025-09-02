@extends('admin.layouts.admin')

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">Edit Payment Gateway</h6>
    </div>

    <div class="card-body">
        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul class="mb-0">
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

            {{-- Gateway Info --}}
            <div class="mb-3">
                <label for="name" class="form-label">Gateway Name</label>
                <input type="text" name="name" id="name" 
                       value="{{ old('name', $paymentGateway->name) }}" 
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="code" class="form-label">Code (unique)</label>
                <input type="text" name="code" id="code" 
                       value="{{ old('code', $paymentGateway->code) }}" 
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $paymentGateway->description) }}</textarea>
            </div>

            <div class="form-check mb-4">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                       {{ $paymentGateway->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>

            {{-- Configurations --}}
            <h5 class="mb-3">Gateway Configurations</h5>
            @forelse ($paymentGateway->configs as $config)
                <div class="border rounded p-3 mb-3">
                    <input type="hidden" name="configs[{{ $config->id }}][id]" value="{{ $config->id }}">

                    <div class="mb-3">
                        <label class="form-label">Key Name</label>
                        <input type="text" name="configs[{{ $config->id }}][key_name]" 
                               value="{{ old("configs.$config->id.key_name", $config->key_name) }}" 
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Key Value</label>
                        <input type="text" name="configs[{{ $config->id }}][key_value]" 
                               value="{{ old("configs.$config->id.key_value", $config->key_value) }}" 
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Environment</label>
                        <select name="configs[{{ $config->id }}][environment]" class="form-select">
                            <option value="sandbox" {{ $config->environment === 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                            <option value="production" {{ $config->environment === 'production' ? 'selected' : '' }}>Production</option>
                        </select>
                    </div>

                    <div class="form-check">
                        <input type="hidden" name="configs[{{ $config->id }}][is_encrypted]" value="0">
                        <input type="checkbox" class="form-check-input" 
                               name="configs[{{ $config->id }}][is_encrypted]" value="1" 
                               {{ $config->is_encrypted ? 'checked' : '' }}>
                        <label class="form-check-label">Encrypted</label>
                    </div>
                </div>
            @empty
                <p class="text-muted">No configurations found for this gateway.</p>
            @endforelse

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
