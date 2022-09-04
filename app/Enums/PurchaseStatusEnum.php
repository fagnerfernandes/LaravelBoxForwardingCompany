<?php

namespace App\Enums;

class PurchaseStatusEnum {
    public const WAITING_PAYMENT    = 1;
    public const WAITING_APPROVAL   = 2;
    public const PAYED              = 3;
    public const UNAUTHORIZED       = 4;
    public const CANCELED           = 5;
}