<?php

namespace App\Observers;

use App\Models\ExtraService;
use App\Models\ShippingExtraService;

class ShippingExtraServiceObserver
{
    public function saving(ShippingExtraService $service)
    {
        $extra_service = ExtraService::find($service->extra_service_id);
        $service->price = $extra_service->price;
    }
}
