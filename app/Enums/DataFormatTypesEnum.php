<?php

namespace App\Enums;

use App\Traits\EnumsHelperTrait;

enum DataFormatTypesEnum {

    use EnumsHelperTrait;

    case UNFORMATED;
    case DATETIME;
    case DATE;
    case TIME;
    case CURRENCY;
}