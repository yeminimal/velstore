@extends('admin.layouts.admin')

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="mb-0">Payment Details</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $payment->id }}</td>
            </tr>
            <tr>
                <th>User</th>
                <td>{{ $payment->user->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Order</th>
                <td>#{{ $payment->order->id ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Gateway</th>
                <td>{{ $payment->gateway->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Amount</th>
                <td>{{ number_format($payment->amount, 2) }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Transaction ID</th>
                <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Back to Payments
        </a>
    </div>
</div>
@endsection
