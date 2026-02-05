<?php

namespace Anuzpandey\LaravelNepaliDate\Traits;

use Anuzpandey\LaravelNepaliDate\Constants\NepaliDate;

trait CalendarDateDataTrait
{
    private function getCalendarData(): array
    {
        return NepaliDate::$CALENDAR_DATA;
    }

    private array $normalMonths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    private array $leapMonths = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    private array $englishNormalMonths = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    private array $englishLeapMonths = [0, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    /* These are initial values for nepali date. */
    private string|int $nepaliYear = 2000;

    private string|int $nepaliMonth = 9;

    private string|int $nepaliDay = 16;     // 17 - 1

    private string|int $dayOfWeek = 6;      // 7 - 1, 0 for sunday, 6 for saturday

    private string|int $englishYear = 1943;

    private string|int $englishMonth = 4;

    private string|int $englishDay = 13;    // 14 - 1
}
