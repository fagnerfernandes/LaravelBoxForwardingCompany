<?php

namespace App\Enums;

use App\Traits\EnumsHelperTrait;

enum AffiliateBenefitTypesEnum: int {
    
    use EnumsHelperTrait;

    case YELO_FEE_PERCENT           = 1;
    case PREMIUM_SERVICE_PERCENT    = 2;
    case EXTRA_SERVICE_PERCENT      = 3;
    case COURTESY_SERVICE           = 4;
    case FREE_SHIPPING              = 5;
}