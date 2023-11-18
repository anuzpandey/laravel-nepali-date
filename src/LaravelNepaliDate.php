<?php

namespace Anuzpandey\LaravelNepaliDate;

use Anuzpandey\LaravelNepaliDate\Traits\CalendarDateDataTrait;
use Anuzpandey\LaravelNepaliDate\Traits\DiffForHumsTrait;
use Anuzpandey\LaravelNepaliDate\Traits\EnglishDateTrait;
use Anuzpandey\LaravelNepaliDate\Traits\HelperTrait;
use Anuzpandey\LaravelNepaliDate\Traits\IsLeapYearTrait;
use Anuzpandey\LaravelNepaliDate\Traits\NepaliDateTrait;
use Carbon\Carbon;

class LaravelNepaliDate
{
    use CalendarDateDataTrait;
    use DiffForHumsTrait;
    use EnglishDateTrait;
    use HelperTrait;
    use IsLeapYearTrait;
    use NepaliDateTrait;

    public function __construct(
        public string|Carbon $date,
    )
    {
    }


    public static function from(string|Carbon $date): LaravelNepaliDate
    {
        $parsedDate = ($date instanceof Carbon)
            ? $date
            : Carbon::parse($date);

        return new static($parsedDate);
    }
}
