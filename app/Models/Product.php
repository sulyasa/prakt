<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 
        'price', 'promo_price', 'brand', 'sizes', 
        'image_path', 'stock', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'float',
        'promo_price' => 'float',
        'stock' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper to get active price (checking for promos)
    public function getActivePriceAttribute()
    {
        return $this->promo_price !== null ? $this->promo_price : $this->price;
    }
}
