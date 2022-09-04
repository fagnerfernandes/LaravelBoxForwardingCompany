<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'package_item_id',
        'amount',
         /**
         * Status de envio (nao é status de pagamento)
         * 0 - Pendente
         * 1 - Enviado
         * 2 - Entregue
         * 3 - Cancelado
         */
        'status',
        'price',
        'shipping_form_id',
        'address_id',
        'tracking_code',
        'observation',
        'shipping_package',
        'shipping_package_price',
        'shipping_package_weight',
        'company_tax',
        'cambioreal_token',
        'cambioreal_code',
        'shipping_id',
        'weight',
        'declaration_amount',
        'declaration_price',
        'declaration',
        'declaration_type_id'
    ];

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function declaration_type()
    {
        return $this->belongsTo(DeclarationType::class);
    }

    public function package_item()
    {
        return $this->belongsTo(PackageItem::class);
    }
}
