<?php

namespace App\Models;

use App\Traits\CustomerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, CustomerTrait, SoftDeletes;

    protected $fillable = ['user_id', 'status', 'track_code'];

    public static $status_options = [
        0 => 'Pendente de pagamento', 
        1 => 'Pago', 
        2 => 'Enviado',
        3 => 'Entregue',
        4 => 'Cancelado',
    ];

    protected $appends = ['status_text'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusTextAttribute()
    {
        return static::$status_options[$this->attributes['status']];
    }
}
