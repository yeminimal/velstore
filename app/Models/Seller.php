<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'store_name', 'store_slug',
        'address', 'logo', 'status'
    ];

    // Automatically create store_slug from store_name
    public static function boot()
    {
        parent::boot();

        static::creating(function ($seller) {
            $seller->store_slug = Str::slug($seller->store_name);
        });
    }
}
