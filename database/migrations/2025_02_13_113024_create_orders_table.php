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
    {Schema::create('orders', function (Blueprint $table) {
        $table->id(); 
        $table->timestamp('order_date')->useCurrent();
        $table->string('status');
        $table->decimal('total_price', 10, 2);
        $table->text('shipping_address');
        $table->text('billing_address');
        $table->string('payment_method');
        $table->string('payment_status');
        $table->string('shipping_method');
        $table->string('tracking_number')->nullable();
        $table->foreignId('product_id')->constrained('products'); // No 'onDelete('cascade')' here
        $table->integer('quantity');
        $table->decimal('unit_price', 10, 2);
        $table->decimal('discount_amount', 10, 2)->nullable();
        $table->string('coupon_code')->nullable();
        $table->timestamps();  // Created_at and updated_at fields
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
