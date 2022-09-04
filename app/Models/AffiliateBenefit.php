<?php

namespace App\Models;

use App\Enums\AffiliateBenefitTypesEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AffiliateBenefit extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'affiliate_id',
        'benefit_type',
        'percent',
        'courtesable_id',
        'courtesable_type',
        'courtesable_max_value',
        'courtesable_valid_until',
        'used_benefit',
        'number_free_shippings',
        'free_shipping_max_value',
        'free_shipping_valid_until'
    ];

    protected $casts = [
        'benefit_type' => AffiliateBenefitTypesEnum::class,
        'courtesable_valid_until' => 'datetime'
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function affiliate(): BelongsTo {
        return $this->belongsTo(Customer::class, 'affiliate_id');
    }

    public function courtesable(): MorphTo {
        return $this->morphTo();
    }

    public function scopeNotUsed(Builder $query): Builder {
        return $query->where('used_benefit', false);
    }

    public function scopeValidCourtesable(Builder $query): Builder {
        return $query->notUsed()->where('courtesable_valid_until', '<', Carbon::now());
    }

    public function scopeBenefitType(Builder $query, AffiliateBenefitTypesEnum $benefitType): Builder {
        return $query->where('benefit_type', $benefitType);
    }
}
