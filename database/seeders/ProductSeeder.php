<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductTranslation;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'vendor_id' => 1,
                'shop_id' => 1,
                'slug' => 'smartphone-xyz',
                'price' => 599.99,
                'discount_price' => 499.99,
                'currency' => 'USD',
                'stock' => 50,
                'SKU' => 'SPH123',
                'category_id' => 1,
                'product_type' => 'Electronics',
                'status' => 1,
                'translations' => [
                    'en' => [
                        'name' => 'Smartphone XYZ',
                        'description' => 'A high-end smartphone with cutting-edge features.',
                        'short_description' => 'Premium smartphone.',
                        'tags' => 'smartphone, mobile, electronics'
                    ]
                ]
            ],
            [
                'vendor_id' => 1,
                'shop_id' => 1,
                'slug' => 'cool-tshirt',
                'price' => 19.99,
                'discount_price' => null,
                'currency' => 'USD',
                'stock' => 100,
                'SKU' => 'TSH123',
                'category_id' => 4,
                'product_type' => 'Fashion',
                'status' => 1,
                'translations' => [
                    'en' => [
                        'name' => 'Cool T-Shirt',
                        'description' => 'A stylish and comfortable t-shirt.',
                        'short_description' => 'Trendy cotton t-shirt.',
                        'tags' => 'tshirt, fashion, clothing'
                    ]
                ]
            ],
        ];

        foreach ($products as $productData) {
            $translations = $productData['translations'];
            unset($productData['translations']);
            
            $product = Product::firstOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );
            
            foreach ($translations as $locale => $translationData) {
                ProductTranslation::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'locale' => $locale
                    ],
                    array_merge($translationData, ['language_code' => $locale])
                );
            }
        }
    }
}
