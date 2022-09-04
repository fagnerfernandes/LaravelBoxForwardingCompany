<?php

namespace App\Observers;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressObserver
{
    public function creating(Address $address)
    {
        if (!empty(Auth::user()->userable_id) && Auth::user()->userable_type == 'App\Models\Customer') {
            $address->user_id = Auth::user()->id;
        }
    }
}
