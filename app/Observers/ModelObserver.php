<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ModelObserver
{
    public function creating(Model $model)
    {
        $model->user_id = Auth::user()->id;
    }
}
