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
        'address', 'logo', 'status', 'password',
    ];

}
