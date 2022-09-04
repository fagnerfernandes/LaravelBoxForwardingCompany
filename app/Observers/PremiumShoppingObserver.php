<?php

namespace App\Observers;

use App\Models\PremiumShopping;
use Illuminate\Support\Facades\Auth;

class PremiumShoppingObserver
{
    public function creating(PremiumShopping $premium_service)
    {
        if (Auth::user()->userable_type == "App\Models\Customer") {
            $premium_service->user_id = Auth::user()->id;
        }


    }
}
