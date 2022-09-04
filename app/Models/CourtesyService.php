<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CourtesyService extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_group_id',
        'courtesable_type',
        'courtesable_id',
        'max_value',
        'valid_days'
    ];

    public function courtesable(): MorphTo {
        return $this->morphTo();
    }

    public function affiliateGroup(): BelongsTo {
        return $this->belongsTo(AffiliateGroup::class);
    }
}
