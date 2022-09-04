<?php

namespace App\Models;

use App\Traits\CustomerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Shipping extends Model implements Auditable
{
    use HasFactory, AuditableTrait, SoftDeletes, CustomerTrait;

    protected $fillable = [
        'shipping_name',
        'amount',
        'weight',
        'weight_mensured',
        'declaration_type_id',
        'declaration',
        'declaration_amount',
        'declaration_price',
        'value',
        'company_fee',
        'postal_fee',
        'label',
         /**
         * Status de envio (nao é status de pagamento)
         * 0 - Pendente
         * 1 - Enviado
         * 2 - Entregue
         * 3 - Cancelado
         */
        'status',
        'insurance',
        'address_id',
        'tracking_code',
        'observation',
        'shipping_form_id',
        'shipping_invoice',
        'boxes_id',
    ];

    const PENDING = 0;
    const INPROGRESS = 1;
    const DELIVERED = 2;
    const CANCELED = 3;
    const WAITING_APPROVAL = 4;

    public $status_options = [
        0 => [
            'name' => 'Pendente',
            'class' => 'warning',
        ],
        1 => [
            'name' => 'Preparando envio',
            'class' => 'primary',
        ],
        2 => [
            'name' => 'Entregue',
            'class' => 'success',
        ],
        3 => [
            'name' => 'Cancelado',
            'class' => 'danger',
        ],
    ];

    protected $appends = ['status_text', 'status_color', 'total_weight'];

    public static $packages = [
        ['name' => 'Caixa', 'weight' => 1.5, 'price' => 0, 'default' => true],
        ['name' => 'Saco Plástico', 'weight' => 1, 'price' => 4, 'default' => false],
    ];

    public function getStatusColorAttribute()
    {
        return $this->status_options[$this->attributes['status']]['class'];
    }

    public function getStatusTextAttribute()
    {
        switch (intval($this->attributes['status'])) {
            case static::PENDING:
                return 'Pendente';
            case static::INPROGRESS:
                return 'Preparando envio';
            case static::DELIVERED:
                return 'Entregue';
            default:
                return 'Cancelado';
        }
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function purchase(): MorphOne {
        return $this->morphOne(Purchase::class, 'purchasable');
    }

    public function items()
    {
        return $this->hasMany(ShippingItem::class, 'shipping_id');
    }

    public function shipping_form()
    {
        return $this->belongsTo(ShippingForm::class);
    }

    public function extra_services()
    {
        return $this->hasMany(ShippingExtraService::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo {
        return $this->belongsTo(Address::class);
    }

    public function getTotalWeightAttribute()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += (float)$item->weight;
        }

        if (!empty($this->extra_services)) {
            foreach ($this->extra_services as $service) {
                $total += (float)$service->weight;
            }
        }

        return $total;
    }

    public function fee(): float {
        return Fee::whereBetween(
                    DB::raw($this->weight), [
                        DB::raw('weight_min'), 
                        DB::raw('weight_max')
                    ])
                    ->first()
                    ->value;

    }
}
