<?php

namespace App\Models;

use App\Observers\PremiumShoppingObserver;
use App\Traits\CustomerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PremiumShopping extends Model
{
    use HasFactory, CustomerTrait, SoftDeletes;

    protected $fillable = [
        'package_item_id',
        'premium_service_id',
        'price',
        'service_description',
        'status',
        /**
         * Status de do serviço extra (nao é status de pagamento)
         * 0 - em aberto
         * 1 - aguardando pagamento
         * 2 - pago
         * 3 - serviço efetuado
         * 4 - aguardando posicao do backoffice para efetuar analise e informar o preço
         * 5 - cancelado
         */
        'user_id',
        'observation',
        'quantity',
        'payment_data',
        'payment_gateway',
        'paypal_transaction_id',
        'paypal_order_id',
        'cambioreal_token',
        'cambioreal_code',
        'cambioreal_url',
    ];

    protected $appends = ['status_text'];

    public static $status_options = [
        1 => 'Aguardando pagamento',
        2 => 'Pago',
        3 => 'Serviço efetuado',
        4 => 'Aguardando valor',
        5 => 'Cancelado',
    ];

    protected static function boot()
    {
        parent::boot();

        static::observe(PremiumShoppingObserver::class);
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package_item()
    {
        return $this->belongsTo(PackageItem::class);
    }

    public function premium_service()
    {
        return $this->belongsTo(PremiumService::class);
    }

    public function purchase(): MorphOne {
        return $this->morphOne(Purchase::class, 'purchasable');
    }
    
    public function files()
    {
        return $this->hasMany(PremiumShoppingImage::class, 'premium_shopping_id');
    }

    public function getStatusTextAttribute()
    {
        $options = [
            0 => 'Em aberto',
            1 => 'Aguardando pagamento',
            2 => 'Pago',
            3 => 'Serviço efetuado',
            4 => 'Aguardando valor',
            5 => 'Cancelado',
        ];

        return $options[$this->attributes['status']];
    }
}
