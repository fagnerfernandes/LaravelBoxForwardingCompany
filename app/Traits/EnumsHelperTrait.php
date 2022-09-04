<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait EnumsHelperTrait {
    public static function getValues(): Collection {
        return collect(Self::cases())->pluck('value');
    }

    public static function hasValue(string $value): bool {
        return Self::getValues()->contains($value);
    }
}