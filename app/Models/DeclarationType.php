<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeclarationType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'family_product_skypostal', 'hs_code_skypostal'];

}
