<?php

namespace App\Models;

use App\Enums\MailTemplateTypesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'subject',
        'content'
    ];

    protected $casts = [
        'type' => MailTemplateTypesEnum::class
    ];
}
