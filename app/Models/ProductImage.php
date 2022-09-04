<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_id', 'image', 'default'];

    protected $appends = ['image_url'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getImageUrlAttribute()
    {
        return url('storage/products/'. $this->attributes['image']);
    }
}
