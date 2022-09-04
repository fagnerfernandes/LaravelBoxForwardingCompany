<?php
namespace App\Traits;

use App\Scopes\CustomerScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait CustomerTrait
{

    public static function fields()
    {
        $model = new self();
        $fields = $model->fillable;
        $fields[] = 'id';
        return $fields;
    }

    public static function bootCustomerTrait()
    {
        static::addGlobalScope(new CustomerScope);

        if (Auth::check() && !(bool)Auth::user()->admin) {
            static::creating(function(Model $model) {
                if (!config('customer.disableScope', false)) {
                    if (in_array($model->getTable(), ['packages'])) {
                        $model->customer_id = Auth::user()->id;
                    } else {
                        $model->user_id = Auth::user()->id;
                    }
                }
            });
        }
    }
}
