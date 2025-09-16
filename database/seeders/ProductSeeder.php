<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // 1. Ensure attributes exist
            $sizeAttr = Attribute::firstOrCreate(['name' => 'Size']);
            $colorAttr = Attribute::firstOrCreate(['name' => 'Color']);

            $sizes = ['Small', 'Medium', 'Large'];
            $colors = ['Red', 'Blue', 'Black'];

            foreach ($sizes as $size) {
                AttributeValue::firstOrCreate([
                    'attribute_id' => $sizeAttr->id,
                    'value' => $size,
                ]);
            }

            foreach ($colors as $color) {
                AttributeValue::firstOrCreate([
                    'attribute_id' => $colorAttr->id,
                    'value' => $color,
                ]);
            }

            // 2. Get vendor, category, brand
            $vendor = Vendor::first() ?? Vendor::factory()->create();
            $category = Category::first() ?? Category::factory()->create();
            $brand = Brand::first() ?? Brand::factory()->create();

            // 3. Demo products with online image URLs
            $products = [
                [
                    'name' => 'Cool T-Shirt',
                    'slug' => 'cool-tshirt',
                    'image' => 'https://i.postimg.cc/4yXLGVJV/T-Shirt.jpg',
                    'description' => 'Trendy T-Shirt available in multiple sizes and colors.',
                ],
                [
                    'name' => 'Sport Shoes',
                    'slug' => 'sport-shoes',
                    'image' => 'https://i.postimg.cc/MGcg37TG/images.jpg', // actual shoes image
                    'description' => 'Comfortable sport shoes for daily use.',
                ],
                [
                    'name' => 'Wireless Headphones',
                    'slug' => 'wireless-headphones',
                    'image' => 'https://i.postimg.cc/c1Y0LSdJ/images-1.jpg',
                    'description' => 'Noise-cancelling wireless headphones with long battery life.',
                ],
                [
                    'name' => 'Travel Backpack',
                    'slug' => 'travel-backpack',
                    'image' => 'https://i.postimg.cc/8cKB8hF6/images-2.jpg', // actual backpack image
                    'description' => 'Durable backpack for travel and outdoor activities.',
                ],
            ];

            // 4. Loop through products
            foreach ($products as $item) {
                $product = Product::create([
                    'shop_id' => 1,
                    'vendor_id' => $vendor->id,
                    'slug' => $item['slug'],
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'product_type' => 'variable',
                    'status' => 1,
                ]);

                // Translations
                $product->translations()->create([
                    'language_code' => 'en',
                    'name' => $item['name'],
                    'description' => $item['description'],
                ]);

                // Image - fetch from URL
                $imageUrl = $item['image'];
                $imageName = basename($imageUrl);

                try {
                    // Try to download and store locally
                    $imageContents = file_get_contents($imageUrl);
                    $localPath = 'products/'.$imageName;
                    Storage::disk('public')->put($localPath, $imageContents);
                } catch (\Exception $e) {
                    // fallback: use online URL directly
                    $localPath = $imageUrl;
                }

                $product->images()->create([
                    'name' => $imageName,
                    'image_url' => $localPath,
                    'type' => 'thumb',
                ]);

                // Variants
                $sizesAttrValues = AttributeValue::where('attribute_id', $sizeAttr->id)->get();
                $colorsAttrValues = AttributeValue::where('attribute_id', $colorAttr->id)->get();

                foreach ($sizesAttrValues as $size) {
                    foreach ($colorsAttrValues as $color) {
                        $variant = $product->variants()->create([
                            'variant_slug' => Str::slug("{$item['name']} {$size->value}-{$color->value}").'-'.uniqid(),
                            'price' => rand(20, 60),
                            'discount_price' => rand(15, 30),
                            'stock' => rand(50, 200),
                            'SKU' => strtoupper(substr($size->value, 0, 1)).substr($color->value, 0, 2).rand(100, 999),
                            'barcode' => null,
                            'weight' => '0.5',
                            'dimensions' => '10x10x2 cm',
                            'is_primary' => 1,
                        ]);

                        $variant->translations()->create([
                            'language_code' => 'en',
                            'name' => "{$size->value} - {$color->value}",
                        ]);

                        // Link attributes
                        foreach ([$size->id, $color->id] as $attrValueId) {
                            DB::table('product_variant_attribute_values')->insert([
                                'product_id' => $product->id,
                                'product_variant_id' => $variant->id,
                                'attribute_value_id' => $attrValueId,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

                            ProductAttributeValue::firstOrCreate([
                                'product_id' => $product->id,
                                'attribute_value_id' => $attrValueId,
                            ]);
                        }
                    }
                }
            }
        });
    }
}
