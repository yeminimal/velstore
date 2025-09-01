<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewayConfig;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentGatewayConfigController extends Controller
{
    public function index()
    {
        return view('admin.payment_gateway_configs.index');
    }

    public function getData(Request $request)
    {
        $configs = PaymentGatewayConfig::with('gateway')->select('payment_gateway_configs.*');

        return DataTables::of($configs)
            ->addColumn('gateway_name', function ($row) {
                return $row->gateway ? $row->gateway->name : '-';
            })
            ->addColumn('key_value', function ($row) {
                return $row->is_encrypted ? '********' : $row->key_value;
            })
            ->addColumn('action', function ($row) {
                return '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $gateways = PaymentGateway::where('is_active', true)->get();

        return view('admin.payment_gateway_configs.create', compact('gateways'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gateway_id' => 'required|exists:payment_gateways,id',
            'key_name' => 'required|string|max:100',
            'key_value' => 'required|string',
            'is_encrypted' => 'boolean',
            'environment' => 'required|in:sandbox,live',
        ]);

        PaymentGatewayConfig::create($request->all());

        return redirect()->route('admin.payment_gateway_configs.index')
            ->with('success', 'Payment Gateway Config added successfully.');
    }

    public function edit(PaymentGatewayConfig $paymentGatewayConfig)
    {
        $gateways = PaymentGateway::where('is_active', true)->get();

        return view('admin.payment_gateway_configs.edit', compact('paymentGatewayConfig', 'gateways'));
    }

    public function update(Request $request, PaymentGatewayConfig $paymentGatewayConfig)
    {
        $request->validate([
            'gateway_id' => 'required|exists:payment_gateways,id',
            'key_name' => 'required|string|max:100',
            'key_value' => 'required|string',
            'is_encrypted' => 'boolean',
            'environment' => 'required|in:sandbox,live',
        ]);

        $paymentGatewayConfig->update($request->all());

        return redirect()->route('admin.payment_gateway_configs.index')
            ->with('success', 'Payment Gateway Config updated successfully.');
    }

    public function destroy(PaymentGatewayConfig $paymentGatewayConfig)
    {
        $paymentGatewayConfig->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment Gateway Config deleted successfully.',
        ]);
    }
}
