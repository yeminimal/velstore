<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the SiteSettingsSeeder
        $this->call(SiteSettingsSeeder::class);
        
    $this->call([
        OrderSeeder::class,
    ]);
    }
}
