<?php

namespace App\Models;

use App\Observers\ShippingExtraServiceObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingExtraService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shipping_id',
        'extra_service_id',
        'price',
        'weight',
    ];

    protected static function boot()
    {
        parent::boot();
        static::observe(ShippingExtraServiceObserver::class);
    }

    public function shipping()
    {
        $this->belongsTo(Shipping::class);
    }

    public function extra_service()
    {
        return $this->belongsTo(ExtraService::class);
    }
}
