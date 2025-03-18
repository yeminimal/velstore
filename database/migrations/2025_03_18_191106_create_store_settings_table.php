<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('store_settings')->insert([
            ['key' => 'default_currency', 'value' => 'USD'],
            ['key' => 'meta_title', 'value' => 'Velstore - Best Laravel eCommerce Solution'],
            ['key' => 'meta_description', 'value' => 'Velstore is an open-source Laravel eCommerce platform, scalable and customizable for online businesses.'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
