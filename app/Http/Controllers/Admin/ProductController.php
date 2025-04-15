<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;

use App\Models\Vendor;
use App\Models\ProductVariantAttributeValue;
use App\Models\Product;
use App\Models\Category;
use App\Models\Language;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;
use App\Services\Admin\CategoryService;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;
use App\Models\Attribute;
use Illuminate\Support\Facades\DB;
use App\Models\ProductTranslation;
use App\Models\ProductVariant;
use App\Models\ProductVariantTranslation;
use App\Models\ProductAttributeValue;
use App\Models\AttributeValue;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;




class ProductController extends Controller
{
    protected $categoryService;
    protected $productService;
  

    public function __construct(CategoryService $categoryService,ProductService $productService)
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
        try {
            return $this->productService->getProductsForDataTable($request);
        } catch (\Exception $e) {
            \Log::error("Error fetching product data: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching product data.'], 500);
        }
    }

    public function create()
    {
      /*  $locale = app()->getLocale();

        $categories = Category::with('translation')->get();    

        $brands = Brand::with('translation')->get();
        
        $attributes = Attribute::with('values.translations')->get();
        $languages = Language::where('active', 1)->get();

        $sizes = Attribute::where('name', 'Size')->first()?->values ?? collect();
        $colors = Attribute::where('name', 'Color')->first()?->values ?? collect();
        return view('admin.products.create', compact('sizes', 'colors','categories', 'brands', 'attributes', 'languages'));*/


        
    // Fetch all languages
    $languages = Language::where('active', 1)->get(); 
    
    // Fetch all categories
    $categories = Category::all(); 
    
    // Fetch all brands
    $brands = Brand::all(); 
    
    // Fetch all attributes with their values
    $attributes = Attribute::with('values.translations')->get(); 
    
    // Fetch sizes and colors separately
    $sizes = Attribute::where('name', 'Size')->first()?->values ?? collect();
    $colors = Attribute::where('name', 'Color')->first()?->values ?? collect();


    // Optionally map size attributes if needed (example for size attribute ID mapping)
    $attributeSizeMap = [
        'small' => AttributeValue::where('attribute_id', $sizes->firstWhere('name', 'Small')->id ?? 0)->pluck('id')->first(),
        'medium' => AttributeValue::where('attribute_id', $sizes->firstWhere('name', 'Medium')->id ?? 0)->pluck('id')->first(),
        'large' => AttributeValue::where('attribute_id', $sizes->firstWhere('name', 'Large')->id ?? 0)->pluck('id')->first(),
    ];

    return view('admin.products.create', compact('languages', 'categories', 'brands', 'attributes', 'sizes', 'colors', 'attributeSizeMap'));

    }



  

    public function store(Request $request)
    {    

        DB::transaction(function () use ($request) {
            // 1. Create product
            $product = Product::create([
                'shop_id' => 1,
                'vendor_id' => 1,
                'slug' => 'need to dynamuc' . rand(10,1000),
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'product_type' => 'variable',
            ]);
    
            // 2. Store translations
            foreach ($request->translations as $lang => $data) {
                $product->translations()->create([
                    'language_code' => $lang,
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
                    'short_description' => $data['short_description'] ?? null,
                    'tags' => $data['tags'] ?? null,
                ]);
            }
    

            $variantIndex = 0;
            foreach ($request->variants as $variantData) {
                $variant = $product->variants()->create([
                    'variant_slug' => Str::slug($variantData['name']) . '-' . uniqid(),
                    'price' => $variantData['price'],
                    'discount_price' => $variantData['discount_price'] ?? null,
                    'stock' => $variantData['stock'],
                    'SKU' => $variantData['SKU'],
                    'barcode' => $variantData['barcode'] ?? null,
                    'weight' => $variantData['weight'] ?? null,
                    'dimensions' => $variantData['dimensions'] ?? null,
                    'is_primary' => false,
                ]);
            
                // Variant Translation (optional)
                $variant->translations()->create([
                    'language_code' => $variantData['language_code'] ?? 'en',
                    'name' => $variantData['name'],
                ]);
            
                // --- Handle size ---
                if (!empty($variantData['size_id'])) {
                    DB::table('product_variant_attribute_values')->insert([
                        'product_id' => $product->id,
                        'product_variant_id' => $variant->id,
                        'attribute_value_id' => $variantData['size_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            
                    // 👇 Also ensure it's added to product_attribute_values (no duplicate)
                    ProductAttributeValue::firstOrCreate([
                        'product_id' => $product->id,
                        'attribute_value_id' => $variantData['size_id'],
                    ]);
                }
            
                // --- Handle color ---
                if (!empty($variantData['color_id'])) {
                    DB::table('product_variant_attribute_values')->insert([
                        'product_id' => $product->id,
                        'product_variant_id' => $variant->id,
                        'attribute_value_id' => $variantData['color_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            
                    // 👇 Also ensure it's added to product_attribute_values (no duplicate)
                    ProductAttributeValue::firstOrCreate([
                        'product_id' => $product->id,
                        'attribute_value_id' => $variantData['color_id'],
                    ]);
                }

                $variantIndex++;
            }
            
        });
    
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');



    }












    public function edit($id)
    {
        $product = Product::with('translations', 'images')->findOrFail($id);
        
        $image = $product->images->first();
        $imageUrl = $image ? $image->image_url : '';
        
        $categories = Category::all();  
        $categories = collect($categories)->map(function ($category) {
            if (isset($category->translations) && $category->translations instanceof \Illuminate\Database\Eloquent\Collection) {
                $translation = $category->translations->firstWhere('language_code', 'en');
                $category->name = $translation ? $translation->name : 'No Name Available';
            } else {
                $category->name = 'No Name Available';
            }
            return $category;
        });

        $languages = Language::active()->get();

        return view('admin.products.edit', compact('product', 'categories', 'languages', 'imageUrl'));
    }
    
    public function update(Request $request, $id)
    {                 
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string',
        ]);

        $translations = $request->input('translations');
        $productData = $request->except('translations'); 

        if (isset($translations['en']['name'])) {
            $productData['name'] = $translations['en']['name']; 
        }

        if (!$request->has('currency')) {
            return redirect()->back()->withErrors(['currency' => 'Currency is required.'])->withInput();
        }

        $result = $this->productService->update($id, $productData, $translations);

        if ($result instanceof \Illuminate\Support\MessageBag) {
            return redirect()->back()->withErrors($result)->withInput();
        }

        return redirect()->route('admin.products.index')->with('success', __('cms.products.updated'));   
    }

    public function destroy($id)
    {
       
        try {
            $result = $this->productService->destroy($id);
    
            // Check if deletion was successful
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' =>  __('cms.products.deleted'),
                ]);
            }
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product!'
            ]);
        } catch (\Exception $e) {
            \Log::error("Error deleting product with ID {$id}: " . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the product.'
            ]);
        }
    } 

    public function updateStatus(Request $request)
    {
       // Validate the incoming request
    $request->validate([
        'id' => 'required|exists:products,id', 
        'status' => 'required|boolean', 
    ]);

    $product = Product::find($request->id);
    $product->status = $request->status;
    $product->save();

    if ($product) {
        return response()->json([
            'success' => true,
            'message' => __('cms.products.status_updated'),
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Product status could not be updated.',
        ]);
    }

    }
}