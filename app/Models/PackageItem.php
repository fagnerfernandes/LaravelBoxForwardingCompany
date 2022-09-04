<?php

namespace App\Models;

use App\Traits\CustomerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PackageItem extends Model implements Auditable
{
    use HasFactory, AuditableTrait, CustomerTrait, SoftDeletes;

    protected $fillable = [
        'reference',
        'image',
        'description',
        'weight',
        'amount',
        'amount_sent',
        'package_id',
        'sent',
        'user_id',
    ];

    protected $appends = ['sent_text'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getSentTextAttribute()
    {
        if (boolval($this->attributes['sent'])) {
            return 'Enviado';
        }
        return 'Disponível';
    }

    public function shipping_item()
    {
        return $this->hasOne(ShippingItem::class, 'package_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
