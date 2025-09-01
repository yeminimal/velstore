@extends('admin.layouts.admin')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">  
@endsection

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">Edit Payment Gateway Config</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.payment_gateway_configs.update', $paymentGatewayConfig->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="gateway_id" class="form-label">Payment Gateway</label>
                <select name="gateway_id" id="gateway_id" class="form-control" required>
                    @foreach($gateways as $gateway)
                        <option value="{{ $gateway->id }}" 
                            {{ $paymentGatewayConfig->gateway_id == $gateway->id ? 'selected' : '' }}>
                            {{ $gateway->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="key_name" class="form-label">Key Name</label>
                <input type="text" name="key_name" id="key_name" class="form-control" 
                       value="{{ old('key_name', $paymentGatewayConfig->key_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="key_value" class="form-label">Key Value</label>
                <input type="text" name="key_value" id="key_value" class="form-control" 
                       value="{{ old('key_value', $paymentGatewayConfig->key_value) }}" required>
                @if($paymentGatewayConfig->is_encrypted)
                    <small class="text-muted">This key is currently encrypted.</small>
                @endif
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_encrypted" id="is_encrypted" class="form-check-input" 
                       value="1" {{ $paymentGatewayConfig->is_encrypted ? 'checked' : '' }}>
                <label for="is_encrypted" class="form-check-label">Encrypt Key</label>
            </div>

            <div class="mb-3">
                <label for="environment" class="form-label">Environment</label>
                <select name="environment" id="environment" class="form-control" required>
                    <option value="sandbox" {{ $paymentGatewayConfig->environment === 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                    <option value="live" {{ $paymentGatewayConfig->environment === 'live' ? 'selected' : '' }}>Live</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Config</button>
            <a href="{{ route('admin.payment_gateway_configs.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
