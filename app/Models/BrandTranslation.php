<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow the convention
    protected $table = 'brand_translations';

    // Fillable attributes for mass assignment
    protected $fillable = ['brand_id', 'locale', 'name', 'description'];

    // Each brand translation belongs to a single brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
