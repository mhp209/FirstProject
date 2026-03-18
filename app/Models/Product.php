<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'qty',
        'sku',
        'new_arrival',
        'is_best_seller',
        'bar_code',
        'desc',
        'status'

    ];

    function product_image() {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
