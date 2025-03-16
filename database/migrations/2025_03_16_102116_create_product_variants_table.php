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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');  // Foreign key to products table
            $table->string('variant_slug')->unique();  // A unique identifier for the variant
            $table->string('name');  // Name of the variant, e.g. 'Large', 'Red', etc.
            $table->string('value');  // Value of the variant, e.g. 'Red', 'M', etc.
            $table->decimal('price', 10, 2);  // Price of the variant
            $table->decimal('discount_price', 10, 2)->nullable();  // Discounted price of the variant
            $table->integer('stock')->default(0);  // Stock quantity for the variant
            $table->string('SKU')->unique();  // SKU for the variant
            $table->string('weight')->nullable();  // Weight specific to the variant
            $table->string('dimensions')->nullable();  // Dimensions specific to the variant
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
