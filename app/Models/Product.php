<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // app/Models/Product.php
    protected $fillable = [
        'name',
        'description',
        'image',
        'variant_id',
        'brand_id',
        'purchase_price',
        'selling_price',
        'stock',
        'is_featured',
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
