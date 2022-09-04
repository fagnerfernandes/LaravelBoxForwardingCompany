<?php

namespace App\Models;

use App\Enums\AffiliateBenefitTypesEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AffiliateCourtesyService extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'service_type',
        'max_value',
        'valid_until',
        'used',
        'used_at',
        'courtesable_type',
        'courtesable_id'
    ];

    protected $casts = [
        'service_type' => AffiliateBenefitTypesEnum::class,
        'valid_until' => 'datetime',
        'used_at' => 'datetime'
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function courtesable(): MorphTo {
        return $this->morphTo('courtesable');
    }

    public function scopeAvailable(Builder $query): Builder {
        return $query->where('used', false)
                     ->where('valid_until', '>', Carbon::now());
    }

    public function scopeOfType(Builder $query, AffiliateBenefitTypesEnum $serviceType): Builder {
        return $query->where('service_type', $serviceType);
    }
}
