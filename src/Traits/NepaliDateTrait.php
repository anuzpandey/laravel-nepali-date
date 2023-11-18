<?php

namespace Anuzpandey\LaravelNepaliDate\Traits;

use Anuzpandey\LaravelNepaliDate\DataTransferObject\NepaliDateArrayData;
use Carbon\Carbon;
use Illuminate\Support\Str;
use RuntimeException;

trait NepaliDateTrait
{
    private array $monthsInNepali = [
        1 => 'वैशाख',
        2 => 'जेठ',
        3 => 'असार',
        4 => 'साउन',
        5 => 'भदौ',
        6 => 'असोज',
        7 => 'कात्तिक',
        8 => 'मंसिर',
        9 => 'पुस',
        10 => 'माघ',
        11 => 'फागुन',
        12 => 'चैत',
    ];

    private array $nepaliMonthInEnglish = [
        1 => 'Baisakh',
        2 => 'Jestha',
        3 => 'Asar',
        4 => 'Shrawan',
        5 => 'Bhadra',
        6 => 'Aswin',
        7 => 'Kartik',
        8 => 'Mangsir',
        9 => 'Poush',
        10 => 'Magh',
        11 => 'Falgun',
        12 => 'Chaitra',
    ];

    private array $dayOfWeekInNepali = [
        1 => 'आइतबार',
        2 => 'सोमबार',
        3 => 'मङ्गलबार',
        4 => 'बुधबार',
        5 => 'बिहिबार',
        6 => 'शुक्रबार',
        7 => 'शनिबार',
    ];

    private array $numbersInNepali = [
        0 => '०',
        1 => '१',
        2 => '२',
        3 => '३',
        4 => '४',
        5 => '५',
        6 => '६',
        7 => '७',
        8 => '८',
        9 => '९',
    ];


    public function toNepaliDate(?string $format = NULL, ?string $locale = 'np'): string
    {
        if ($format) {
            return $this->toFormattedNepaliDate($format, $locale);
        }

        $checkIfIsInRange = $this->isInEnglishDateRange($this->date);

        if (!$checkIfIsInRange) {
            throw new RuntimeException($checkIfIsInRange);
        }

        $totalEnglishDays = $this->calculateTotalEnglishDays($this->date->year, $this->date->month, $this->date->day);

        $this->performCalculationBasedOn($totalEnglishDays);

        $year = $this->nepaliYear;
        $month = $this->nepaliMonth < 10 ? '0' . $this->nepaliMonth : $this->nepaliMonth;
        $day = $this->nepaliDay < 10 ? '0' . $this->nepaliDay : $this->nepaliDay;

        return $year . '-' . $month . '-' . $day;
    }


    public function toFormattedNepaliDate(
        string $format = 'Y-m-d',
        string $locale = 'np'
    ): string
    {
        $nepaliDateArray = $this->toNepaliDateArray();

        return $this->formatDateString($format, $locale, $nepaliDateArray);
    }


    public function toNepaliDateArray(): NepaliDateArrayData
    {
        $this->toNepaliDate();

        $nepaliMonth = $this->nepaliMonth > 9 ? $this->nepaliMonth : '0' . $this->nepaliMonth;
        $nepaliDay = $this->nepaliDay > 9 ? $this->nepaliDay : '0' . $this->nepaliDay;

        return NepaliDateArrayData::from([
            'year' => $this->nepaliYear,
            'month' => $nepaliMonth,
            'day' => $nepaliDay,
            'npYear' => $this->formattedNepaliNumber($this->nepaliYear),
            'npMonth' => $this->formattedNepaliNumber($nepaliMonth),
            'npDay' => $this->formattedNepaliNumber($nepaliDay),
            'dayName' => $this->dayOfWeekInEnglish[$this->dayOfWeek],
            'monthName' => $this->nepaliMonthInEnglish[$this->nepaliMonth],
            'npDayName' => $this->formattedNepaliDateOfWeek($this->dayOfWeek),
            'npMonthName' => $this->monthsInNepali[$this->nepaliMonth],
        ]);
    }


    public function getShortDayName(string $npDayName, string $locale = 'np'): string
    {
        if ($locale === 'en') {
            return match ($npDayName) {
                'Sunday' => 'Sun',
                'Monday' => 'Mon',
                'Tuesday' => 'Tue',
                'Wednesday' => 'Wed',
                'Thursday' => 'Thu',
                'Friday' => 'Fri',
                'Saturday' => 'Sat',
            };
        }

        return match ($npDayName) {
            'आइतबार' => 'आइत',
            'सोमबार' => 'सोम',
            'मङ्गलबार' => 'मङ्गल',
            'बुधबार' => 'बुध',
            'बिहिबार' => 'बिहि',
            'शुक्रबार' => 'शुक्र',
            'शनिबार' => 'शनि',
        };
    }


    private function calculateTotalEnglishDays($year, $month, $day)
    {
        $totalEnglishDays = 0;

        for ($i = 0; $i < ($year - 1944); $i++) {
            if ($this->isLeapYear(1944 + $i)) {
                for ($j = 0; $j < 12; $j++) {
                    $totalEnglishDays += $this->leapMonths[$j];
                }
            } else {
                for ($j = 0; $j < 12; $j++) {
                    $totalEnglishDays += $this->normalMonths[$j];
                }
            }
        }

        for ($i = 0; $i < ($month - 1); $i++) {
            if ($this->isLeapYear($year)) {
                $totalEnglishDays += $this->leapMonths[$i];
            } else {
                $totalEnglishDays += $this->normalMonths[$i];
            }
        }

        $totalEnglishDays += $day;

        return $totalEnglishDays;
    }


    private function performCalculationBasedOn($totalEnglishDays): void
    {
        $i = 0;
        $j = $this->nepaliMonth;

        while ($totalEnglishDays != 0) {
            $lastDayOfMonth = $this->calendarData[$i][$j];

            $this->nepaliDay++;
            $this->dayOfWeek++;

            if ($this->nepaliDay > $lastDayOfMonth) {
                $this->nepaliMonth++;
                $this->nepaliDay = 1;
                $j++;
            }

            if ($this->dayOfWeek > 7) {
                $this->dayOfWeek = 1;
            }

            if ($this->nepaliMonth > 12) {
                $this->nepaliYear++;
                $this->nepaliMonth = 1;
            }

            if ($j > 12) {
                $j = 1;
                $i++;
            }

            $totalEnglishDays--;
        }
    }


    private function formattedNepaliDateOfWeek($dayOfWeek)
    {
        return $this->dayOfWeekInNepali[$dayOfWeek];
    }


    private function formattedNepaliNumber($value): string
    {
        $numbers = str_split($value);

        foreach ($numbers as $key => $number) {
            $numbers[$key] = $this->numbersInNepali[$number];
        }

        return implode('', $numbers);
    }


    private function isInEnglishDateRange(Carbon $date): string|bool
    {
        if ($date->year < 1944 || $date->year > 2033) {
            return 'Date is out of range. Please provide date between 1944-01-01 to 2033-12-31';
        }

        if ($date->month < 1 || $date->month > 12) {
            return 'Month is out of range. Please provide month between 1-12';
        }

        if ($date->day < 1 || $date->day > 31) {
            return 'Day is out of range. Please provide day between 1-31';
        }

        return true;
    }

}
