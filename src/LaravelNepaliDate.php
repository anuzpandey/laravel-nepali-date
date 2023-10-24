<?php

namespace Anuzpandey\LaravelNepaliDate;

use Anuzpandey\LaravelNepaliDate\DataTransferObject\NepaliDateArrayData;
use Anuzpandey\LaravelNepaliDate\Traits\CalendarDateDataTrait;
use Anuzpandey\LaravelNepaliDate\Traits\DiffForHumsTrait;
use Anuzpandey\LaravelNepaliDate\Traits\EnglishDateTrait;
use Anuzpandey\LaravelNepaliDate\Traits\IsLeapYearTrait;
use Anuzpandey\LaravelNepaliDate\Traits\NepaliDateTrait;
use Carbon\Carbon;
use Illuminate\Support\Str;
use RuntimeException;

class LaravelNepaliDate
{
    use CalendarDateDataTrait;
    use NepaliDateTrait;
    use EnglishDateTrait;
    use IsLeapYearTrait;
    use DiffForHumsTrait;


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


    public function toEnglishDate(): string
    {
        $year = $this->year;
        $month = $this->month;
        $day = $this->day;

        $parsedDate = Carbon::parse($year . '-' . $month . '-' . $day);

        $initialEnglishYear = 1943;
        $initialEnglishMonth = 4;
        $initialEnglishDay = 14 - 1;

        $initialNepaliYear = 2000;

        $totalNepaliDays = 0;

        $_day = 4 - 1;
        $k = 0;

        $_months = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $_leap_months = [0, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        $checkIfIsInRange = $this->isInNepaliDateRange($parsedDate);

        if (!$checkIfIsInRange) {
            throw new RuntimeException($checkIfIsInRange);
        }

        for ($i = 0; $i < ($year - $initialNepaliYear); $i++) {
            for ($j = 1; $j <= 12; $j++) {
                $totalNepaliDays += $this->calendarData[$k][$j];
            }
            $k++;
        }

        // Count Total Days in terms of month
        for ($j = 1; $j < $month; $j++) {
            $totalNepaliDays += $this->calendarData[$k][$j];
        }

        // Count Total Days in Terms of days
        $totalNepaliDays += $day;

        // Calculation of equivalent english date...
        $totalEnglishDays = $initialEnglishDay;
        $_month = $initialEnglishMonth;
        $_year = $initialEnglishYear;

        while ($totalNepaliDays != 0) {
            if ($this->isLeapYear($_year)) {
                $a = $_leap_months[$_month];
            } else {
                $a = $_months[$_month];
            }

            $totalEnglishDays++;
            $_day++;

            if ($totalEnglishDays > $a) {
                $_month++;
                $totalEnglishDays = 1;
                if ($_month > 12) {
                    $_year++;
                    $_month = 1;
                }
            }

            if ($_day > 7) {
                $_day = 1;
            }

            $totalNepaliDays--;
        }

        $this->englishYear = $_year;
        $this->englishMonth = $_month;
        $this->englishDay = $totalEnglishDays;
        $this->dayOfWeek = $_day;

        return $_year . '-' . $_month . '-' . $totalEnglishDays;
    }


    public function toEnglishDateArray(): array
    {
        $this->toEnglishDate();

        return [
            'year' => $this->englishYear,
            'month' => $this->englishMonth,
            'day' => $this->englishDay,
            'day_of_week' => $this->dayOfWeek,
        ];
    }


    public function convertEnToNpNumber($number): array|string
    {
        $en_number = [
            "0",
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
        ];

        $np_number = [
            "०",
            "१",
            "२",
            "३",
            "४",
            "५",
            "६",
            "७",
            "८",
            "९",
        ];

        return str_replace($en_number, $np_number, $number);
    }


    public function convertEnToNpWord($word): array|string
    {
        $en_word = [
            'years',
            'year',
            'months',
            'month',
            'days',
            'day',
            'weeks',
            'week',
            'ago',
            'from now',
            'seconds',
            'second',
            'hours',
            'hour',
            'minutes',
            'minute',
        ];

        $np_word = [
            'वर्ष',
            'वर्ष',
            'महिना',
            'महिना',
            'दिन',
            'दिन',
            'हप्ता',
            'हप्ता',
            'पहिले',
            'पछि',
            'सेकेन्ड',
            'सेकेन्ड',
            'घण्टा',
            'घण्टा',
            'मिनेट',
            'मिनेट'
        ];

        return str_replace($en_word, $np_word, $word);
    }


    public function isInNepaliDateRange(Carbon $date): string|bool
    {
        if ($date->year < 2000 || $date->year > 2089) {
            return 'Date is out of range. Please provide date between 2000 to 2089';
        }

        if ($date->month < 1 || $date->month > 12) {
            return 'Month is out of range. Please provide month between 1-12';
        }

        if ($date->day < 1 || $date->day > 32) {
            return 'Day is out of range. Please provide day between 1-32';
        }

        return TRUE;
    }


    private function invalidDateFormatException(): void
    {
        throw new RuntimeException('Invalid date format provided. Valid formats are: "d F Y, l" - "l, d F Y" - "d F Y" - "d-m-Y" - "Y-m-d" - "d/m/Y" - "Y/m/d"');
    }
}
