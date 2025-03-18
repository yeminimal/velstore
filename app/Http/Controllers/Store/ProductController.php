<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
        ->with(['translation', 'thumbnail'])
        ->withCount('reviews')
        ->withAvg('reviews', 'rating')
        ->firstOrFail();
        return view('themes.xylo.product-detail', compact('product'));
    }
}
