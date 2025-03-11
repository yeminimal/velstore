<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class Velstore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:velstore {--locale= : Set the application locale}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Velstore Ecommerce Built with Laravel.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running composer dump-autoload...');

        $this->info('Running migrations...');
        $this->call('migrate');

        $this->info('Creating categories and products...');
        $this->createCategoriesAndProducts();

        $this->info('Categories and products created successfully.');

        $this->info('Creating admin user...');
        $this->createAdminUser();
        exec('composer dump-autoload');
        $this->info('Admin user created successfully.');

        $availableLocales = ['en' => 'English', 'es' => 'Spanish', 'fr' => 'French', 'de' => 'German'];

        $locale = $this->choice(
            'Please select a locale to set for the application',
            array_keys($availableLocales),
            'en' /* Default value */
        );

        if (!array_key_exists($locale, $availableLocales)) {
            $this->error("Invalid locale '{$locale}'. Supported locales are: " . implode(', ', array_keys($availableLocales)));
            return 1;
        }

        $this->updateEnvFile('APP_LOCALE', $locale);

        $this->info("Application language set to: $locale");

        $this->info('Matrix installation completed successfully.');

        $this->info('Installing npm packages...');
        exec('npm install');

        $this->info('Generating application key...');
        Artisan::call('key:generate');
        $this->info('Application key generated successfully.');

        return Command::SUCCESS;
    }


    /**
     * Create the admin user.
     *
     * @return void
     */
    protected function createAdminUser()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('abc123'),
            ]
        );

        if ($user->wasRecentlyCreated) {
            $this->info('Admin user created successfully.');
        } else {
            $this->info('Admin user already exists.');
        }
    }


    protected function createCategoriesAndProducts()
    {
       
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


    /**
     * Update the .env file with a given key-value pair.
     */
    protected function updateEnvFile($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $content = file_get_contents($path);
            $pattern = "/^{$key}=.*/m";

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, "{$key}={$value}", $content);
            } else {
                $content .= PHP_EOL . "{$key}={$value}";
            }

            file_put_contents($path, $content);
        }
    }
}

