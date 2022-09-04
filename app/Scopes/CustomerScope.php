<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Log;

class CustomerScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check() && !boolval(auth()->user()->admin) && auth()->user()->userable_type == 'App\Models\Customer') {
            if ($model->getTable() == 'packages') {
                $builder->where('customer_id', auth()->user()->id);
            } else {
                $builder->where('user_id', auth()->user()->id);
            }
        }
    }
}
