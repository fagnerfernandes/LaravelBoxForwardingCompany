<?php

namespace App\Models;

use App\Observers\CreditObserver;
use App\Traits\CustomerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credit extends Model
{
    use HasFactory, CustomerTrait, SoftDeletes;

    protected $fillable = ['user_id', 'amount', 'type', 'is_buying', 'description', 'status'];

    public static $status_options = [0 => 'Aguardando confirmação', 1 => 'Confirmado'];

    protected $appends = ['status_text'];

    /* protected static function boot()
    {
        parent::boot();

        static::observe(CreditObserver::class);
    } */

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusTextAttribute()
    {
        return static::$status_options[$this->attributes['status']];
    }

    public function scopeIn($query) {
        return $query->where('type', 'in');
    }

    public function scopeOut($query) {
        return $query->where('type', 'out');
    }

    public function purchase(): MorphOne {
        return $this->morphOne(Purchase::class, 'purchasable');
    }
}
