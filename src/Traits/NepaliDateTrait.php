<?php

namespace Anuzpandey\LaravelNepaliDate\Traits;

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


    public function calculateTotalEnglishDays($year, $month, $day)
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


    public function performCalculationBasedOn($totalEnglishDays): void
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

}
