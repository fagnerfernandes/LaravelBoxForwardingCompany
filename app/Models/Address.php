<?php

namespace App\Models;

use App\Observers\AddressObserver;
use App\Traits\CustomerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Address extends Model implements Auditable
{
    use HasFactory, AuditableTrait, CustomerTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'postal_code',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::observe(AddressObserver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
