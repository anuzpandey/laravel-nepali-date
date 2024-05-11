<?php

namespace Anuzpandey\LaravelNepaliDate\Traits;

use Anuzpandey\LaravelNepaliDate\DataTransferObject\NepaliDateArrayData;
use Illuminate\Support\Str;

trait HelperTrait
{
    public function convertEnToNpNumber($number): array|string
    {
        $en_number = [
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
        ];

        $np_number = [
            '०',
            '१',
            '२',
            '३',
            '४',
            '५',
            '६',
            '७',
            '८',
            '९',
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
            'मिनेट',
        ];

        return str_replace($en_word, $np_word, $word);
    }

    public function getFormattedString(string $format, array $formatData, string $locale): string
    {
        $formattedString = '';

        for ($i = 0, $iMax = strlen($format); $i < $iMax; $i++) {
            $char = $format[$i];

            if (array_key_exists($char, $formatData)) {
                if ($locale === 'np') {
                    if ($char === 'S') {
                        continue;
                    }
                    $formattedString .= $formatData[$char];
                } else {
                    if ($char === 'S') {
                        $formattedString .= $this->getOrdinalSuffix((int) $formatData['j']);
                    } else {
                        $formattedString .= $formatData[$char];
                    }
                }
            } else {
                $formattedString .= $char;
            }
        }

        return $formattedString;
    }

    public function getOrdinalSuffix(int $number): string
    {
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            return 'th';
        }

        return match ($number % 10) {
            1 => 'st',
            2 => 'nd',
            3 => 'rd',
            default => 'th',
        };
    }

    private function getNepaliLocaleFormattingCharacters(NepaliDateArrayData $nepaliDateArray): array
    {
        return [
            'Y' => $nepaliDateArray->npYear,
            'y' => Str::substr($nepaliDateArray->npYear, 2, 2),
            'F' => $nepaliDateArray->npMonthName,
            'm' => $nepaliDateArray->npMonth,
            'n' => $nepaliDateArray->npMonth > 9 ? $nepaliDateArray->npMonth : Str::substr($nepaliDateArray->npMonth, 1, 1),
            'd' => $nepaliDateArray->npDay,
            'j' => $nepaliDateArray->npDay > 9 ? $nepaliDateArray->npDay : Str::substr($nepaliDateArray->npDay, 1, 1),
            'l' => $nepaliDateArray->npDayName,
            'D' => $this->getShortDayName($nepaliDateArray->npDayName),
        ];
    }

    private function getEnglishLocaleFormattingCharacters(NepaliDateArrayData $nepaliDateArray): array
    {
        return [
            'Y' => $nepaliDateArray->year,
            'y' => Str::substr($nepaliDateArray->year, 2, 2),
            'F' => $nepaliDateArray->monthName,
            'm' => $nepaliDateArray->month,
            'n' => $nepaliDateArray->month > 9 ? $nepaliDateArray->month : Str::substr($nepaliDateArray->month, 1, 1),
            'd' => $nepaliDateArray->day,
            'j' => $nepaliDateArray->day > 9 ? $nepaliDateArray->day : Str::substr($nepaliDateArray->day, 1, 1),
            'l' => $nepaliDateArray->dayName,
            'D' => $this->getShortDayName($nepaliDateArray->dayName, 'en'),
        ];
    }

    private function formatDateString(string $format, string $locale, $dateArray): string
    {
        $formattedArray = ($locale === 'en')
            ? $this->getEnglishLocaleFormattingCharacters($dateArray)
            : $this->getNepaliLocaleFormattingCharacters($dateArray);

        $formatData = [
            'Y' => $formattedArray['Y'],
            'y' => $formattedArray['y'],
            'F' => $formattedArray['F'],
            'm' => $formattedArray['m'],
            'n' => $formattedArray['n'],
            'd' => $formattedArray['d'],
            'j' => $formattedArray['j'],
            'l' => $formattedArray['l'],
            'D' => $formattedArray['D'],
            'S' => $formattedArray['j'],
        ];

        return $this->getFormattedString($format, $formatData, $locale);
    }
}
