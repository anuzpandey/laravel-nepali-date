<?php

namespace Anuzpandey\LaravelNepaliDate\Traits;

trait IsLeapYearTrait
{
    public function isLeapYear($year): bool
    {
        return ($year % 100 == 0)
            ? ($year % 400 == 0)
            : ($year % 4 == 0);
    }
}
