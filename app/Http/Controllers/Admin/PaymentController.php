<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index()
    {
        return view('admin.payments.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $payments = Payment::with(['user', 'order', 'gateway'])->select('payments.*');

            return DataTables::of($payments)
                ->addColumn('user', fn ($row) => $row->user?->name ?? '—')
                ->addColumn('order', fn ($row) => $row->order ? 'Order #'.$row->order->id : '—')
                ->addColumn('gateway', fn ($row) => $row->gateway?->name ?? '—')
                ->addColumn('action', function ($row) {
                    return '<span class="border border-danger dt-trash rounded-3 d-inline-block" onclick="deletePayment('.$row->id.')"> 
                            <i class="bi bi-trash-fill text-danger"></i>
                        </span>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json(['success' => true, 'message' => 'Payment deleted successfully.']);
    }
}
