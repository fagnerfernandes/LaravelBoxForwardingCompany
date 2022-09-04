<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'slug',
        'description',
        'shipping_included',
        'price',
        'promotional_price',
        'category_id',
        'active',
        'amount',
        'weight',
    ];

    protected static function boot()
    {
        parent::boot();

        static::observe(ProductObserver::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function getDescriptionAttribute()
    {
        return nl2br($this->attributes['description']);
    }
}
