<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Services\Store\CartService;
use App\Models\ProductVariant;

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
        $quantity = (int) ($request->quantity ?? 1);
        $attributeValueIds = $request->attribute_value_ids ?? [];
    
        $product = Product::with('thumbnail')->findOrFail($productId);
    
        $variant = null;
        if ($product->product_type == 'simple') {
            $variant = $product->variants()->where('is_primary', 1)->first();
        } else {
            $variant = $this->matchVariant($productId, $attributeValueIds);
        }
    
        if (!$variant) {
            return response()->json([
                'message' => 'Selected variant is not available.'
            ], 422);
        }

        $attributePairs = [];
        foreach ($attributeValueIds as $attributeValueId) {
            $attributeValue = \App\Models\AttributeValue::with('attribute')->find($attributeValueId);
            if ($attributeValue && $attributeValue->attribute) {
                $attributePairs[$attributeValue->attribute->id] = $attributeValue->id;
            }
        }
    
        $cart = Session::get('cart', []);
    
        $attributeValueIdsSorted = collect($attributeValueIds)->sort()->values()->implode('_');
        $key = "cart_{$productId}_{$attributeValueIdsSorted}";
    
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'variant_id' => $variant->id, // even for simple product
                'variant_name' => $variant->name ?? $product->translation->name,
                'price' => $variant->converted_discount_price ?? $variant->converted_price,
                'quantity' => $quantity,
                'image' => optional($variant->images->first() ?? $product->thumbnail)->image_url,
                'attributes' => $attributePairs // key: attribute_id => attribute_value_id
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
    
    private function matchVariant($productId, array $attributeValueIds)
    {
        
        if (empty($attributeValueIds)) {
            // Simple product — return primary variant
            return ProductVariant::where('product_id', $productId)->where('is_primary', true)->first();
        }
        
        // Variable product — match variant with exact attribute values
        $variants = ProductVariant::with('attributeValues')
            ->where('product_id', $productId)
            ->get();

        foreach ($variants as $variant) {
            $variantAttrIds = $variant->attributeValues->pluck('id')->sort()->values();
            if ($variantAttrIds->toArray() === collect($attributeValueIds)->sort()->values()->toArray()) {
                return $variant;
            }
        }
        /*$variants = ProductVariant::with('attributeValues')
        ->where('product_id', $productId)
        ->whereHas('attributeValues', function ($query) use ($attributeValueIds) {
            // Clarify which table's 'id' column we're referring to
            $query->whereIn('attribute_values.id', $attributeValueIds);
        })
        ->get();

        foreach ($variants as $variant) {
            $variantAttrIds = $variant->attributeValues->pluck('id')->sort()->values();
            if ($variantAttrIds->toArray() === collect($attributeValueIds)->sort()->values()->toArray()) {
                return $variant;
            }
        }*/

        /*
        $variants = ProductVariant::with('attributeValues')
            ->where('product_id', $productId)
            ->whereHas('attributeValues', function ($query) use ($attributeValueIds) {
                // Filter variants based on the provided attribute value IDs
                $query->whereIn('attribute_values.id', $attributeValueIds);
            })
            ->get();

        dd($variants->toArray());

        foreach ($variants as $variant) {
            // Collect sorted attribute value IDs for the current variant
            $variantAttrIds = $variant->attributeValues->pluck('id')->sort()->values();
            dd($attributeValueIds, $variantAttrIds);
            // Ensure both are sorted arrays and compare them
            if ($variantAttrIds->diff($attributeValueIds)->isEmpty()) {
                return $variant;
            }
        }
        */

        // Retrieve variants based on the selected attribute values
        /*$variants = ProductVariant::with('attributeValues')
            ->where('product_id', $productId)
            ->whereHas('attributeValues', function ($query) use ($attributeValueIds) {
                // Match variants that have the selected attribute values
                $query->whereIn('attribute_values.id', $attributeValueIds);
            })
            ->get();

        // Step 2: Iterate through the variants and find an exact match
        foreach ($variants as $variant) {
            // Sort and compare the attribute values of the current variant
            $variantAttrIds = $variant->attributeValues->pluck('id')->sort()->values();
            $selectedAttrIds = collect($attributeValueIds)->sort()->values();

            // If both sorted attribute IDs match, return the variant
            if ($variantAttrIds->diff($selectedAttrIds)->isEmpty()) {
                return $variant;  // Return the matching variant
            }
        }*/

    
        return null; // No exact match found
    }
    


    public function updateCart(Request $request)
    {
        $cart = Session::get('cart', []);
    
        foreach ($request->cart as $item) {
            if (isset($cart[$item['product_id']])) {
                $cart[$item['product_id']]['quantity'] = max(1, intval($item['quantity']));
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

        if (empty($cart)) {
            session()->forget('cart_coupon');
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
