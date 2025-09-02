@extends('admin.layouts.admin')

@section('content')
<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="mb-0">Refund Details</h6>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $refund->id }}</td>
            </tr>
            <tr>
                <th>Payment</th>
                <td>
                    @if($refund->payment)
                        Payment #{{ $refund->payment->id }} 
                        (Amount: {{ $refund->payment->amount }} – Status: {{ $refund->payment->status }})
                    @else
                        —
                    @endif
                </td>
            </tr>
            <tr>
                <th>Amount</th>
                <td>{{ $refund->amount }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $refund->status }}</td>
            </tr>
            <tr>
                <th>Reason</th>
                <td>{{ $refund->reason ?? '—' }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $refund->created_at }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $refund->updated_at }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.refunds.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>
@endsection
