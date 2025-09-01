<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RefundController extends Controller
{
    public function index()
    {
        return view('admin.refunds.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $refunds = Refund::with('payment')->select('refunds.*');

            return DataTables::of($refunds)
                ->addColumn('payment', fn ($row) => $row->payment ? 'Payment #'.$row->payment->id : '—')
                ->addColumn('action', function ($row) {
                    return '<span class="border border-danger dt-trash rounded-3 d-inline-block" onclick="deleteRefund('.$row->id.')"> 
                                <i class="bi bi-trash-fill text-danger"></i>
                            </span>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function destroy(Refund $refund)
    {
        $refund->delete();

        return response()->json(['success' => true, 'message' => 'Refund deleted successfully.']);
    }
}
