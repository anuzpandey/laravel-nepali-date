<?php

namespace Anuzpandey\LaravelNepaliDate\Mixin;

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use Carbon\Carbon;
use Closure;

/**
 * @mixin Carbon
 */
class NepaliDateMixin
{
    public function toNepaliDate(): Closure
    {
        return function (?string $format = 'Y-m-d', ?string $locale = 'np') {
            $date = $this->toDateString();

            return LaravelNepaliDate::from($date)->toNepaliDate($format, $locale);
        };
    }

    public function toEnglishDate(): Closure
    {
        return function (?string $format = 'Y-m-d', ?string $locale = 'en') {
            $date = $this->toDateString();

            return LaravelNepaliDate::from($date)->toEnglishDate($format, $locale);
        };
    }
}
