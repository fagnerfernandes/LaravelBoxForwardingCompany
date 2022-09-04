<?php

namespace App\Models;

use App\Observers\StockObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'amount',
        'type', /** I - IN | O - Out */
        'description',
    ];

    protected $appends = ['type_text'];

    public static $types = [
        'I' => 'Entrada',
        'O' => 'Saída',
    ];

    protected static function boot()
    {
        parent::boot();

        static::observe(StockObserver::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTypeTextAttribute()
    {
        if ($this->attributes['type'] == 'I') {
            return 'Entrada';
        } else if ($this->attributes['type'] == 'O') {
            return 'Saída';
        }
        return null;
    }
}
