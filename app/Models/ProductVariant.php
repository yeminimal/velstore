<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory; 

    protected $fillable = [
        'product_id',
        'variant_slug',
        'name',
        'value',
        'price',
        'discount_price',
        'stock',
        'SKU',
        'weight',
        'dimensions',
    ];

    // Relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship with the ProductVariantTranslation model
    public function translations()
    {
        return $this->hasMany(ProductVariantTranslation::class);
    }
}
