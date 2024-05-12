<?php

namespace Anuzpandey\LaravelNepaliDate;

use Anuzpandey\LaravelNepaliDate\Traits\CalendarDateDataTrait;
use Anuzpandey\LaravelNepaliDate\Traits\DiffForHumsTrait;
use Anuzpandey\LaravelNepaliDate\Traits\EnglishDateTrait;
use Anuzpandey\LaravelNepaliDate\Traits\HelperTrait;
use Anuzpandey\LaravelNepaliDate\Traits\IsLeapYearTrait;
use Anuzpandey\LaravelNepaliDate\Traits\NepaliDateTrait;
use Illuminate\Support\Str;

class LaravelNepaliDate
{
    use CalendarDateDataTrait;
    use DiffForHumsTrait;
    use EnglishDateTrait;
    use HelperTrait;
    use IsLeapYearTrait;
    use NepaliDateTrait;

    public function __construct(
        public int|string $year,
        public int|string $month,
        public int|string $day,
    ) {
    }

    public static function from(string $date): LaravelNepaliDate
    {
        [$year, $month, $day] = Str::of($date)->explode('-')->toArray();

        return new static((int) $year, (int) $month, (int) $day);
    }
}
