<?php

namespace App\Models;

use App\Observers\TransactionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $status_options = [
        'Cobrança gerada',
        'Pago',
        'Cancelado',
    ];

    protected $fillable = [
        'gateway',
        'bill_url',
        'amount',
        'status',
        'token',
    ];

    protected $gateways = [
        'cambioreal' => \App\ExternalApi\Payments\CambioReal::class,
        'paypal' => \App\ExternalApi\Payments\Paypal::class,
        'internal' => \App\ExternalApi\Payments\Internal::class
    ];

    protected $appends = ['status_text'];

    protected static function boot()
    {
        parent::boot();

        static::observe(TransactionObserver::class);
    }

    public function getStatus($gateway, $status)
    {
        return $this->gateways[$gateway]::getStatus($status);
    }

    public function getStatusTextAttribute()
    {
        return $this->status_options[$this->attributes['status']];
    }

    public function scopeConfirmed($query) {
        return $query->where('status', 1);
    }

    public function payment(): HasOne {
        return $this->hasOne(Payment::class);
    }
}
