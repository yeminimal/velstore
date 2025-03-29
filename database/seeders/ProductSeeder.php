<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductVariant;
use App\Models\ProductVariantTranslation;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductAttributeValueTranslation;

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
                'slug' => 'cool-tshirt',
                'price' => 19.99,
                'discount_price' => null,
                'currency' => 'USD',
                'stock' => 100,
                'SKU' => 'TSH123',
                'category_id' => 4,
                'brand_id' => null,
                'weight' => 0.5,
                'dimensions' => '30x20x2',
                'product_type' => 'Fashion',
                'status' => 1,
                'translations' => [
                    'en' => [
                        'name' => 'Cool T-Shirt',
                        'description' => 'A stylish and comfortable t-shirt.',
                        'short_description' => 'Trendy cotton t-shirt.',
                        'tags' => 'tshirt, fashion, clothing'
                    ],
                    'fr' => [
                        'name' => 'T-shirt Cool',
                        'description' => 'Un t-shirt élégant et confortable.',
                        'short_description' => 'T-shirt en coton tendance.',
                        'tags' => 'tshirt, mode, vêtements'
                    ]
                ],
                'attributes' => [
                    'Color' => [
                        'en' => ['Red', 'Black'],
                        'fr' => ['Rouge', 'Noir']
                    ],
                    'Size' => [
                        'en' => ['Small', 'Large'],
                        'fr' => ['Petit', 'Grand']
                    ]
                ],
                'variants' => [
                    [
                        'variant_slug' => 'cool-tshirt-red-small',
                        'price' => 25.99,
                        'discount_price' => 19.99,
                        'stock' => 30,
                        'SKU' => 'TSH-RED-SMALL',
                        'translations' => [
                            'en' => 'Cool T-Shirt - Red Small',
                            'fr' => 'T-shirt Cool - Rouge Petit'
                        ]
                    ],
                    [
                        'variant_slug' => 'cool-tshirt-red-large',
                        'price' => 29.99,
                        'discount_price' => 24.99,
                        'stock' => 20,
                        'SKU' => 'TSH-RED-LARGE',
                        'translations' => [
                            'en' => 'Cool T-Shirt - Red Large',
                            'fr' => 'T-shirt Cool - Rouge Grand'
                        ]
                    ]
                ]
            ]
        ];

        foreach ($products as $productData) {
            $translations = $productData['translations'];
            $attributes = $productData['attributes'];
            $variants = $productData['variants'];

            unset($productData['translations'], $productData['attributes'], $productData['variants']);

            // Insert or update the product
            $product = Product::updateOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );

            // Insert product translations
            foreach ($translations as $languageCode => $translationData) {
                ProductTranslation::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'language_code' => $languageCode
                    ],
                    $translationData
                );
            }

            // Insert product attributes
            $attributeIds = [];
            foreach ($attributes as $attributeName => $values) {
                $attribute = ProductAttribute::updateOrCreate(
                    ['product_id' => $product->id, 'attribute_name' => $attributeName]
                );
                $attributeIds[$attributeName] = $attribute->id;

                // Insert attribute values
                foreach ($values['en'] as $index => $value) {
                    $attributeValue = ProductAttributeValue::updateOrCreate([
                        'product_attribute_id' => $attribute->id,
                        'value' => $value
                    ]);

                    // Insert attribute value translations
                    foreach ($values as $langCode => $translations) {
                        ProductAttributeValueTranslation::updateOrCreate([
                            'product_attribute_value_id' => $attributeValue->id,
                            'language_code' => $langCode,
                            'translated_value' => $translations[$index]
                        ]);
                    }
                }
            }

            // Insert product variants
            foreach ($variants as $variantData) {
                $variantTranslations = $variantData['translations'];
                unset($variantData['translations']);

                $variant = ProductVariant::updateOrCreate(
                    ['variant_slug' => $variantData['variant_slug']],
                    array_merge($variantData, ['product_id' => $product->id])
                );

                // Insert variant translations
                foreach ($variantTranslations as $languageCode => $variantName) {
                    ProductVariantTranslation::updateOrCreate([
                        'product_variant_id' => $variant->id,
                        'language_code' => $languageCode,
                        'name' => $variantName
                    ]);
                }
            }
        }
    }
}
