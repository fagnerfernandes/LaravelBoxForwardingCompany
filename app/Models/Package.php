<?php

namespace App\Models;

use App\Observers\ModelObserver;
use App\Scopes\CustomerScope;
use App\Traits\CustomerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Package extends Model implements Auditable
{
    use HasFactory, AuditableTrait, SoftDeletes, CustomerTrait;

    protected $fillable = [
        'sku',
        'location',
        'name',
        'weight',
        'photo',
        'user_id',
        'customer_id',
        'tracking_code',
    ];

    protected static function boot()
    {
        parent::boot();

        static::observe(ModelObserver::class);
        static::addGlobalScope(new CustomerScope());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(PackageItem::class, 'package_id');
    }
}
