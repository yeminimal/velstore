<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
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
            $languages = Language::where('active', 1)->get();

            // ----------------------
            // 1. Create Attributes (not multilingual)
            // ----------------------
            $sizeAttr = Attribute::firstOrCreate(['name' => 'Size']);
            $colorAttr = Attribute::firstOrCreate(['name' => 'Color']);

            // ----------------------
            // 2. Attribute Values (with translations)
            // ----------------------
            $sizes = ['Small', 'Medium', 'Large'];
            $colors = ['Red', 'Blue', 'Black'];

            foreach ($sizes as $size) {
                $attrValue = AttributeValue::firstOrCreate([
                    'attribute_id' => $sizeAttr->id,
                    'value' => $size,
                ]);

                foreach ($languages as $lang) {
                    $attrValue->translations()->firstOrCreate([
                        'language_code' => $lang->code,
                    ], [
                        'translated_value' => match ($lang->code) {
                            'es' => match ($size) {
                                'Small' => 'Pequeño',
                                'Medium' => 'Mediano',
                                'Large' => 'Grande',
                                default => $size,
                            },
                            'de' => match ($size) {
                                'Small' => 'Klein',
                                'Medium' => 'Mittel',
                                'Large' => 'Groß',
                                default => $size,
                            },
                            default => $size,
                        },
                    ]);
                }
            }

            foreach ($colors as $color) {
                $attrValue = AttributeValue::firstOrCreate([
                    'attribute_id' => $colorAttr->id,
                    'value' => $color,
                ]);

                foreach ($languages as $lang) {
                    $attrValue->translations()->firstOrCreate([
                        'language_code' => $lang->code,
                    ], [
                        'translated_value' => match ($lang->code) {
                            'es' => match ($color) {
                                'Red' => 'Rojo',
                                'Blue' => 'Azul',
                                'Black' => 'Negro',
                                default => $color,
                            },
                            'de' => match ($color) {
                                'Red' => 'Rot',
                                'Blue' => 'Blau',
                                'Black' => 'Schwarz',
                                default => $color,
                            },
                            default => $color,
                        },
                    ]);
                }
            }

            // ----------------------
            // 3. Vendors, Categories, Brands
            // ----------------------
            $vendor = Vendor::first() ?? Vendor::factory()->create();
            $category = Category::first() ?? Category::factory()->create();
            $brand = Brand::first() ?? Brand::factory()->create();

            // ----------------------
            // 4. Products with Variants
            // ----------------------
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
                    'image' => 'https://i.postimg.cc/MGcg37TG/images.jpg',
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
                    'image' => 'https://i.postimg.cc/8cKB8hF6/images-2.jpg',
                    'description' => 'Durable backpack for travel and outdoor activities.',
                ],
            ];

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

                // 🔹 Product translations
                foreach ($languages as $lang) {
                    $product->translations()->create([
                        'language_code' => $lang->code,
                        'name' => $item['name'],
                        'description' => $item['description'],
                    ]);
                }

                // 🔹 Product image
                $imageUrl = $item['image'];
                $imageName = basename($imageUrl);
                try {
                    $imageContents = file_get_contents($imageUrl);
                    $localPath = 'products/'.$imageName;
                    Storage::disk('public')->put($localPath, $imageContents);
                } catch (\Exception $e) {
                    $localPath = $imageUrl;
                }

                $product->images()->create([
                    'name' => $imageName,
                    'image_url' => $localPath,
                    'type' => 'thumb',
                ]);

                // 🔹 Product variants
                $sizesAttrValues = AttributeValue::where('attribute_id', $sizeAttr->id)->get();
                $colorsAttrValues = AttributeValue::where('attribute_id', $colorAttr->id)->get();

                foreach ($sizesAttrValues as $size) {
                    foreach ($colorsAttrValues as $color) {
                        $price = rand(20, 60);
                        $discountPrice = rand(10, $price);

                        $variant = $product->variants()->create([
                            'variant_slug' => Str::slug("{$item['name']} {$size->value}-{$color->value}").'-'.uniqid(),
                            'price' => $price,
                            'discount_price' => $discountPrice,
                            'stock' => rand(50, 200),
                            'SKU' => strtoupper(substr($size->value, 0, 1)).substr($color->value, 0, 2).rand(100, 999),
                            'barcode' => null,
                            'weight' => '0.5',
                            'dimensions' => '10x10x2 cm',
                            'is_primary' => 1,
                        ]);

                        foreach ($languages as $lang) {
                            $variant->translations()->create([
                                'language_code' => $lang->code,
                                'name' => "{$size->value} - {$color->value}",
                            ]);
                        }

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
