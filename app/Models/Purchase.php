<?php

namespace App\Models;

use App\Enums\PaymentMethodsEnum;
use App\Enums\PurchaseStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchasable_type',
        'purchasable_id',
        'value',
        'purchase_status_id'
    ];

    public function payments(): HasMany {
        return $this->hasMany(Payment::class);
    }

    public function paymentCambioReal(): HasOne {
        return $this->hasOne(Payment::class)->where('payment_method', PaymentMethodsEnum::CAMBIOREAL);
    }

    public function paymentPaypal(): HasOne {
        return $this->hasOne(Payment::class)->where('payment_method', PaymentMethodsEnum::PAYPAL);
    }

    public function purchasable(): MorphTo {
        return $this->morphTo();
    }

    public function purchaseStatus(): BelongsTo {
        return $this->belongsTo(PurchaseStatus::class);
    }

    public function totalPayed() {
        return $this->payments->sum('value');
    }

    public function totalOpen() {
        return $this->value - $this->totalPayed();
    }

    public function payed() {
        return ($this->totalPayed() == $this->value);
    }

    public function statusText() {
        switch ($this->purchase_status_id) {
            case PurchaseStatusEnum::WAITING_PAYMENT:
                return 'Aguardando Pagamento';
                break;
            case PurchaseStatusEnum::WAITING_APPROVAL:
                return 'Aguardando Aprovação';
                break;
            case PurchaseStatusEnum::PAYED:
                return 'Pago';
                break;
            case PurchaseStatusEnum::UNAUTHORIZED:
                return 'Não Autorizado';
                break;
            case PurchaseStatusEnum::CANCELED:
                return 'Cancelado';
                break;
        }
    }
}
