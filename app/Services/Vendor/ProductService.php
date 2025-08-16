<?php

namespace App\Services\Vendor;

use App\Models\Product;
use App\Repositories\Vendor\Product\ProductRepository;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductsForDataTable($request)
    {
        $vendorId = auth()->guard('vendor')->id();

        $products = Product::with([
            'translations',
            'primaryVariant' => function ($q) {
                $q->where('is_primary', 1);
            },
        ])
            ->where('vendor_id', '=', $vendorId)
            ->whereHas('variants', function ($query) {
                $query->where('is_primary', 1);
            });

        return \DataTables::of($products)
            ->addColumn('name', function ($product) {
                $translation = $product->translations->firstWhere('language_code', 'en');

                return $translation ? $translation->name : 'No name available';
            })
            ->addColumn('price', function ($product) {
                $primaryVariant = $product->variants->firstWhere('is_primary', true);

                return $primaryVariant ? '$'.number_format($primaryVariant->price, 2) : 'No price';
            })
            ->addColumn('status', function ($product) {
                return $product->status;
            })
            ->addColumn('action', function ($product) {
                return '
                    <a href="'.route('vendor.products.edit', $product->id).'" class="btn btn-primary btn-sm">Edit</a>
                    <form action="'.route('vendor.products.destroy', $product->id).'" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this product?\');">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
