<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Fee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['weight_min', 'weight_max', 'value'];

    public static function getValue($weight)
    {
        $fee = static::where('weight_max', '>=', $weight)
            ->where('weight_min', '<=', $weight)
            ->first();
        if ($fee) return $fee->value;
        return null;
    }

    public function scopeCompanyFee(Builder $query, float $weight): Builder {
        return $query->whereBetween(DB::raw($weight), [DB::raw('weight_min'), DB::raw('weight_max')]);
    }
}
