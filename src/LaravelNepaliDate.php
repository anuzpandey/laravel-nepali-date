<?php

namespace Anuzpandey\LaravelNepaliDate;

use Anuzpandey\LaravelNepaliDate\DataTransferObject\NepaliDateArrayData;
use Anuzpandey\LaravelNepaliDate\Traits\CalendarDateDataTrait;
use Anuzpandey\LaravelNepaliDate\Traits\DiffForHumsTrait;
use Anuzpandey\LaravelNepaliDate\Traits\EnglishDateTrait;
use Anuzpandey\LaravelNepaliDate\Traits\HelperTrait;
use Anuzpandey\LaravelNepaliDate\Traits\IsLeapYearTrait;
use Anuzpandey\LaravelNepaliDate\Traits\NepaliDateTrait;
use Carbon\Carbon;
use RuntimeException;

class LaravelNepaliDate
{
    use CalendarDateDataTrait;
    use NepaliDateTrait;
    use EnglishDateTrait;
    use IsLeapYearTrait;
    use DiffForHumsTrait;
    use HelperTrait;


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
