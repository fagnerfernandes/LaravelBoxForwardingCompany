<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Shop extends Model implements Auditable
{
    use HasFactory, AuditableTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'link',
        'logo',
        'description',
        'status',
    ];

    protected $appends = ['status_text'];

    const RECOMMENDED = 'R';
    const FORBIDDEN = 'F';

    public function getStatusTextAttribute()
    {
        switch ($this->attributes['status']) {
            case static::RECOMMENDED: return 'Recomendada';
            case static::FORBIDDEN: return 'Não Recomendada';
            default: return 'N/D';
        }
    }
}
