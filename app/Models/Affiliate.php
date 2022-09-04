<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliated_to_id',
        'customer_id'
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function affiliatedTo(): BelongsTo {
        return $this->belongsTo(Customer::class, 'affiliated_to_id');
    }
}
