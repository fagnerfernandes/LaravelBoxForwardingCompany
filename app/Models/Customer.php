<?php

namespace App\Models;

use App\Enums\AffiliateBenefitTypesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;

class Customer extends Model implements Auditable
{
    use HasFactory, AuditableTrait, SoftDeletes;

    protected $fillable = [
        'document',
        'active',
        'suite',
        'affiliate_token',
        'affiliate_group_id',
        'affiliated_to_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function(Model $model) {
            $last_suite = DB::table('customers')->max('suite');
            $model->suite = ($last_suite + 1);
            $model->affiliate_token = Str::random(10);
        });
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function packages(): HasMany {
        return $this->hasMany(Package::class);
    }

    public function affiliates()
    {
        return $this->hasMany(Customer::class, 'affiliated_to_id', 'id');
    }

    
    public function affiliatedTo()
    {
        return $this->belongsTo(Customer::class, 'affiliated_to_id');
    }
    
    public function affiliateGroup(): BelongsTo {
        return $this->belongsTo(AffiliateGroup::class)
                    ->withDefault(fn() => AffiliateGroup::default()->first());
    }

    public function affiliateBenefits(): HasMany {
        return $this->hasMany(AffiliateBenefit::class);
    }

    public function affiliateCourtesyServices(): HasMany {
        return $this->hasMany(AffiliateCourtesyService::class);
    }
    
    public static function search(string $term): array
    {
        $term = filter_var($term, FILTER_SANITIZE_STRING);
        $sql = 'select u.id, concat(c.suite, " - ", u.name) as text '
             . 'from customers c, users u '
             . 'where c.id = u.userable_id and c.active = 1 '
             . 'and (suite like "%'. $term .'%" or u.name like "%'. $term .'%") '
             . 'limit 50';

        // dd($sql);

        // $bindings = ['suite' => $term, 'name' => $term];
        return DB::select($sql);
    }
}
