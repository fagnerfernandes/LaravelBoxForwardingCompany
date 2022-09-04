<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'transaction_id',
        'payment_method',
        'value'
    ];

    public function purchase(): BelongsTo {
        return $this->belongsTo(Purchase::class);
    }

    public function transaction(): BelongsTo {
        return $this->belongsTo(Transaction::class);
    }
}
