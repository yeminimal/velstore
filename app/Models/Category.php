<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use HasFactory;

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'slug',
        'parent_category_id',
        'status',
    ];

    // Define the relationship with CategoryTranslation
    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(CategoryTranslation::class)
                    ->where('language_code', App::getLocale());
    }

    // Define the relationship for the parent category (self-referencing)
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    // Define the relationship for child categories
    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }
}
