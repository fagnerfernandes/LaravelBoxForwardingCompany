<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Faq extends Model implements Auditable
{
    use HasFactory, AuditableTrait, SoftDeletes;

    protected $fillable = [
        'question',
        'answer',
    ];
}
