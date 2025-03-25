<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Services\Store\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $product = Product::with(['translations', 'thumbnail'])->findOrFail($productId);

            $cart[$productId] = [
                'product_id' => $product->id, // Store only the ID for dynamic fetching
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => optional($product->thumbnail)->image_url,
            ];
        }

        Session::put('cart', $cart);
        Session::put('cart_count', array_sum(array_column($cart, 'quantity')));

        return response()->json([
            'message' => 'Product added to cart successfully.',
            'cart' => $cart,
            'cart_count' => Session::get('cart_count')
        ]);
    }

    public function updateCart(Request $request)
    {
        $cart = Session::get('cart', []);
    
        foreach ($request->cart as $item) {
            if (isset($cart[$item['product_id']])) {
                $cart[$item['product_id']]['quantity'] = max(1, intval($item['quantity'])); // Ensure quantity is at least 1
            }
        }
    
        Session::put('cart', $cart);
        Session::put('cart_count', array_sum(array_column($cart, 'quantity')));
    
        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart' => $cart
        ]);
    }

    public function viewCart()
    {
        $cart = Session::get('cart', []);
        return view('themes.xylo.cart', compact('cart'));
    }

    public function removeFromCart(Request $request)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            Session::put('cart', $cart);
        }

        return response()->json(['message' => 'Product removed from cart.', 'cart' => $cart]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        
        $result = $this->cartService->applyCoupon($request->code);

        return response()->json($result);
    }

    public function removeCoupon()
    {
        $this->cartService->removeCoupon();
        return response()->json(['success' => true, 'message' => 'Coupon removed successfully!']);
    }
}
