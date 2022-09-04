<?php

namespace App\ExternalApi\Payments;

class Internal {
    //just return concluded status, since this is an internal transaction
    public static function getStatus(): int {
        return 1;
    }
}