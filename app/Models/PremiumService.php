<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PremiumService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'need_description',
    ];

    public static function isCustom($premium_serevice_id): bool
    {
        $service = PremiumService::find($premium_serevice_id);
        if (empty($service->price) || (int)$service->price == 0) {
            return true;
        }
        return false;
    }

    public function courtesyService(): MorphOne {
        return $this->morphOne(CourtesyService::class, 'courtesable');
    }

    public function affiliateCourtesyService(): MorphOne {
        return $this->morphOne(AffiliateCourtesyService::class, 'courtesable');
    }
}
