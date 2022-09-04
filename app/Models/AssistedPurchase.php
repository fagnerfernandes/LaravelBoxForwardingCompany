<?php

namespace App\Models;

use App\Traits\CustomerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class AssistedPurchase extends Model implements Auditable
{
    use HasFactory, AuditableTrait, CustomerTrait, SoftDeletes;

    protected $fillable = [
        'title',
        'link',
        'color',
        'color_optional',
        'size',
        'size_optional',
        'price',
        'quantity',
        'observations',
        'user_id',
        'customer_id',
        'status',
        /**
         * Status de compra assistida (nao é status de pagamento)
         * 0 - Pendente de aprovacao da plataforma
         * 1 - Aprovado
         * 2 - Comprado
         * 3 - Cancelado
         */
        'paid',
        'payment_link',
    ];

    const PENDING = 0;
    const GENERATED_PAYMENT = 1;
    const BOUGHT = 2;
    const CANCELED = 3;

    protected $appends = ['status_text'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function purchase(): MorphOne {
        return $this->morphOne(Purchase::class, 'purchasable');
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function getStatusTextAttribute()
    {
        switch ($this->attributes['status']) {
            case static::GENERATED_PAYMENT: return 'Fatura em aberto';
            case static::BOUGHT: return 'Comprado';
            case static::CANCELED: return 'Cancelada';
            default: return 'Pendente';
        }
    }
}
