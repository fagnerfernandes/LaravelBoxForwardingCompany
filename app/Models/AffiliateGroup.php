<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AffiliateGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_default',
        'company_fee_percent',
        'premium_services_percent',
        'extra_services_percent',
        'number_free_shippings',
        'free_shipping_max_value',
        'free_shipping_valid_days'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    public function customers(): HasMany {
        return $this->hasMany(Customer::class);
    }

    public function scopeDefault($query) {
        return $query->where('is_default', true);
    }

    public function courtesyServices(): HasMany {
        return $this->hasMany(CourtesyService::class);
    }
}
