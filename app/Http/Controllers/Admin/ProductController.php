<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\Vendor;
use App\Services\Admin\CategoryService;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $categoryService;

    protected $productService;

    public function __construct(CategoryService $categoryService, ProductService $productService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    public function index()
    {
        return view('admin.products.index');
    }

    public function getProducts(Request $request)
    {
        return $this->productService->getProducts($request);
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        $vendors = Vendor::all();
        $brands = Brand::all();
        $sizes = AttributeValue::where('attribute_id', 1)->get();
        $colors = AttributeValue::where('attribute_id', 2)->get();

        return view('admin.products.create', compact('categories', 'vendors', 'brands', 'sizes', 'colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vendor_id' => 'required|exists:vendors,id',
            'brand_id' => 'required|exists:brands,id',
            'sku' => 'required|string|max:100|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'variants.*.sku' => 'nullable|string|max:100|distinct',
            'variants.*.price' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::create([
                'name' => $request->input('name'),
                'vendor_id' => $request->input('vendor_id'),
                'brand_id' => $request->input('brand_id'),
                'sku' => $request->input('sku'),
                'price' => $request->input('price'),
            ]);

            if ($request->has('variants')) {
                foreach ($request->input('variants') as $variantData) {
                    $variant = $product->variants()->create([
                        'name' => $variantData['name'],
                        'sku' => $variantData['sku'],
                        'price' => $variantData['price'],
                        'variant_slug' => Str::slug($variantData['name']) . '-' . uniqid(),
                    ]);

                    foreach (['size_id', 'color_id'] as $attrType) {
                        if (!empty($variantData[$attrType])) {
                            DB::table('product_variant_attribute_values')->insert([
                                'product_id' => $product->id,
                                'product_variant_id' => $variant->id,
                                'attribute_value_id' => $variantData[$attrType],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

                            ProductAttributeValue::firstOrCreate([
                                'product_id' => $product->id,
                                'attribute_value_id' => $variantData[$attrType],
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', __('Product created successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::whereNull('parent_id')->get();
        $vendors = Vendor::all();
        $brands = Brand::all();
        $sizes = AttributeValue::where('attribute_id', 1)->get();
        $colors = AttributeValue::where('attribute_id', 2)->get();

        return view('admin.products.edit', compact('product', 'categories', 'vendors', 'brands', 'sizes', 'colors'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vendor_id' => 'required|exists:vendors,id',
            'brand_id' => 'required|exists:brands,id',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'variants.*.sku' => 'nullable|string|max:100|distinct',
            'variants.*.price' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $product->update([
                'name' => $request->input('name'),
                'vendor_id' => $request->input('vendor_id'),
                'brand_id' => $request->input('brand_id'),
                'sku' => $request->input('sku'),
                'price' => $request->input('price'),
            ]);

            $product->variants()->delete();
            DB::table('product_variant_attribute_values')->where('product_id', $product->id)->delete();

            if ($request->has('variants')) {
                foreach ($request->input('variants') as $variantData) {
                    $variant = $product->variants()->create([
                        'name' => $variantData['name'],
                        'sku' => $variantData['sku'],
                        'price' => $variantData['price'],
                        'variant_slug' => Str::slug($variantData['name']) . '-' . uniqid(),
                    ]);

                    foreach (['size_id', 'color_id'] as $attrType) {
                        if (!empty($variantData[$attrType])) {
                            DB::table('product_variant_attribute_values')->insert([
                                'product_id' => $product->id,
                                'product_variant_id' => $variant->id,
                                'attribute_value_id' => $variantData[$attrType],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

                            ProductAttributeValue::firstOrCreate([
                                'product_id' => $product->id,
                                'attribute_value_id' => $variantData[$attrType],
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', __('Product updated successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            $product->variants()->delete();
            DB::table('product_variant_attribute_values')->where('product_id', $product->id)->delete();
            $product->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => __('Product deleted successfully.')]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
