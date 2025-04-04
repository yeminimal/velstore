<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;

class ProductController extends Controller
{
    /*public function show($slug)
    {
        $product = Product::where('slug', $slug)
        ->with(['translation', 'thumbnail', 'reviews'])
        ->withCount('reviews')
        ->withAvg('reviews', 'rating')
        ->firstOrFail();
        return view('themes.xylo.product-detail', compact('product'));
    }*/

    public function show($slug)
    {
        $product = Product::with([
            'attributeValues.attribute',
            'attributeValues.translations',
            'translations',
            'reviews',
            'primaryVariant',
            'variants.attributeValues',
            'images'
        ])->withAvg('reviews', 'rating')
          ->withCount('reviews')
          ->where('slug', $slug)
          ->firstOrFail();

          $variants = $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'price' => $variant->converted_price,
                'discount_price' => $variant->converted_discount_price,
                'attribute_value_ids' => $variant->attributeValues->pluck('id')->sort()->values()->toArray(),
            ];
        })->values()->toArray();
        return view('themes.xylo.product-detail', compact('product', 'variants'));
    }
}
