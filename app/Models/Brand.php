<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow the convention
    protected $table = 'brands';

    // Fillable attributes for mass assignment
    protected $fillable = ['slug', 'logo_url', 'status'];

    // A brand can have many translations
    public function translations()
    {
        return $this->hasMany(BrandTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(BrandTranslation::class)->where('locale', app()->getLocale());
    }
   

}
