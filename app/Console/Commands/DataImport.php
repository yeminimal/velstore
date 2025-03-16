<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class DataImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting data import...');

        $this->info('Creating categories and products...');
        $this->createCategoriesAndProducts();
        $this->info('Categories and products created successfully.');

        $this->info('Running language seeder');
        $this->call('db:seed', ['--class' => 'LanguageSeeder']);

        $this->info('Running menu seeder');
        $this->call('db:seed', ['--class' => 'MenuSeeder']);

        $this->info('Data import completed successfully!');
    }

    protected function createCategoriesAndProducts()
    {
        $seller = Seller::firstOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name' => 'Seller',
                'email' => 'seller@example.com',
                'password' => Hash::make('abc123'),
                'phone' => '+923001234567',
            ]
        );

        $shop = Shop::firstOrCreate(
            ['name' => 'Soft Shoes'],
            [
                'seller_id' => 1,
                'name' => 'Soft Shoes',
                'logo' => 'N/A',
                'description' => 'Luxurious comfort in every step. Crafted with premium materials for a soft, stylish, and effortless walking experience. '
            ]
        );

        $electronics = Category::firstOrCreate(
            ['slug' => 'electronics'],
            ['status' => true]
        );

        $fashion = Category::firstOrCreate(
            ['slug' => 'fashion'],
            ['status' => true]
        );

        $smartphones = Category::firstOrCreate(
            ['slug' => 'smartphones', 'parent_category_id' => $electronics->id],
            ['status' => true]
        );

        $tShirts = Category::firstOrCreate(
            ['slug' => 't-shirts', 'parent_category_id' => $fashion->id],
            ['status' => true]
        );

        $products = [
            [
                'seller_id' => 1,
                'shop_id' => 1,
                'slug' => 'smartphone-xyz',
                'price' => 599.99,
                'discount_price' => 499.99,
                'currency' => 'USD',
                'stock' => 50,
                'SKU' => 'SPH123',
                'category_id' => $smartphones->id,
                'product_type' => 'Electronics',
                'status' => 1,
            ],
            [
                'seller_id' => 1,
                'shop_id' => 1,
                'slug' => 'cool-tshirt',
                'price' => 19.99,
                'discount_price' => null,
                'currency' => 'USD',
                'stock' => 100,
                'SKU' => 'TSH123',
                'category_id' => $tShirts->id,
                'product_type' => 'Fashion',
                'status' => 1,
            ],
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(
                ['slug' => $productData['slug']],
                $productData 
            );
        }
    } 
}
