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
        Schema::create('product_variant_translations', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('product_variant_id'); // Foreign key to product_variants table
            $table->string('locale');  // Language code (e.g., 'en', 'fr')
            $table->string('language_code', 5)->default('en'); // Optional: if you want a default language
            $table->string('name'); // Translated name of the variant
            $table->string('value')->nullable();  // Translated value of the variant (like 'Red', 'Large', etc.)
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            
            // Unique constraint on product_variant_id and locale to ensure one translation per language
            $table->unique(['product_variant_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_translations');
    }
};
