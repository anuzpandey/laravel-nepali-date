<?php

namespace Anuzpandey\LaravelNepaliDate\Mixin;

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use Carbon\Carbon;
use Closure;

class CarbonMixin
{

    public function toNepaliDate(): Closure
    {
        return function (
            ?string $format = 'Y-m-d',
            ?string $locale = 'np'
        ) {
            $date = $this->toDateString();

            return LaravelNepaliDate::from($date)->toNepaliDate($format, $locale);
        };
    }

}
