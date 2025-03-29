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
        Schema::create('product_attribute_value_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_attribute_value_id')
                  ->constrained('product_attribute_values', 'id')
                  ->onDelete('cascade')
                  ->index('pav_trans_value_fk'); // Shorter foreign key index name
        
            $table->string('language_code', 5); // e.g., 'en', 'fr', 'es'
            $table->string('translated_value'); // e.g., 'Rouge', 'Grande'
            $table->timestamps();
        
            // Shorter unique constraint name
            $table->unique(['product_attribute_value_id', 'language_code'], 'pav_trans_lang_unique');
        });        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute_value_translations');
    }
};
