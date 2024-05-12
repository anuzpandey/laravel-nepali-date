<?php

namespace Anuzpandey\LaravelNepaliDate\Traits;

use Anuzpandey\LaravelNepaliDate\DataTransferObject\NepaliDateArrayData;
use RuntimeException;

trait EnglishDateTrait
{
    private array $monthsInEnglish = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    private array $englishMonthInNepali = [
        1 => 'जनवरी',
        2 => 'फेब्रुअरी',
        3 => 'मार्च',
        4 => 'अप्रिल',
        5 => 'मे',
        6 => 'जुन',
        7 => 'जुलाई',
        8 => 'अगस्ट',
        9 => 'सेप्टेम्बर',
        10 => 'अक्टोबर',
        11 => 'नोभेम्बर',
        12 => 'डिसेम्बर',
    ];

    private array $dayOfWeekInEnglish = [
        1 => 'Sunday',
        2 => 'Monday',
        3 => 'Tuesday',
        4 => 'Wednesday',
        5 => 'Thursday',
        6 => 'Friday',
        7 => 'Saturday',
    ];

    private array $numbersInEnglish = [
        0 => '0',
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
    ];

    public function toEnglishDate(?string $format = null, ?string $locale = null): string
    {
        $checkIfIsInRange = $this->isInNepaliDateRange($this->year, $this->month, $this->day);

        if (! $checkIfIsInRange) {
            throw new RuntimeException($checkIfIsInRange);
        }

        $totalNepaliDays = $this->calculateTotalNepaliDays();

        $this->performCalculationBasedonNepaliDays($totalNepaliDays);

        return $this->toFormattedEnglishDate(
            $format ?? config('nepali-date.default_format'),
            $locale ?? config('nepali-date.default_locale'),
        );
    }

    public function toEnglishDateArray(): NepaliDateArrayData
    {
        return NepaliDateArrayData::from([
            'year' => $this->englishYear,
            'month' => $this->englishMonth,
            'day' => $this->englishDay,
            'npYear' => $this->convertEnToNpNumber($this->englishYear),
            'npMonth' => $this->convertEnToNpNumber($this->englishMonth),
            'npDay' => $this->convertEnToNpNumber($this->englishDay),
            'dayName' => $this->dayOfWeekInEnglish[$this->dayOfWeek],
            'monthName' => $this->monthsInEnglish[(int) $this->englishMonth],
            'npDayName' => $this->formattedNepaliDateOfWeek($this->dayOfWeek),
            'npMonthName' => $this->englishMonthInNepali[(int) $this->englishMonth],
        ]);
    }

    public function isInNepaliDateRange(int $year, int $month, int $day): string|bool
    {
        if ($year < 2000 || $year > 2089) {
            return 'Date is out of range. Please provide date between 2000 to 2089';
        }

        if ($month < 1 || $month > 12) {
            return 'Month is out of range. Please provide month between 1-12';
        }

        if ($day < 1 || $day > 32) {
            return 'Day is out of range. Please provide day between 1-32';
        }

        return true;
    }

    public function calculateTotalNepaliDays()
    {
        $totalNepaliDays = 0;
        $k = 0;

        for ($i = 0; $i < ($this->year - $this->nepaliYear); $i++) {
            for ($j = 1; $j <= 12; $j++) {
                $totalNepaliDays += $this->calendarData[$k][$j];
            }
            $k++;
        }

        // Count Total Days in terms of month
        for ($j = 1; $j < $this->month; $j++) {
            $totalNepaliDays += $this->calendarData[$k][$j];
        }

        // Count Total Days in Terms of days
        $totalNepaliDays += $this->day;

        return $totalNepaliDays;
    }

    public function performCalculationBasedOnNepaliDays(string|int $totalNepaliDays): void
    {
        $_day = 4 - 1;

        // Calculation of equivalent english date...
        $_year = $this->englishYear;
        $_month = $this->englishMonth;
        $totalEnglishDays = $this->englishDay;

        while ($totalNepaliDays != 0) {
            $a = ($this->isLeapYear($_year))
                ? $this->englishLeapMonths[$_month]
                : $this->englishNormalMonths[$_month];

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
        $this->englishMonth = $_month > 9 ? $_month : '0'.$_month;
        $this->englishDay = $totalEnglishDays > 9 ? $totalEnglishDays : '0'.$totalEnglishDays;
        $this->dayOfWeek = $_day;
    }

    public function toFormattedEnglishDate(string $format, string $locale): string
    {
        $englishDateArray = $this->toEnglishDateArray();

        return $this->formatDateString($format, $locale, $englishDateArray);
    }
}
