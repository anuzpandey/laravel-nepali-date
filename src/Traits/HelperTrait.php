<?php

namespace Anuzpandey\LaravelNepaliDate\Traits;

trait HelperTrait
{
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


    private function invalidDateFormatException(): void
    {
        throw new \RuntimeException('Invalid date format provided. Valid formats are: "d F Y, l" - "l, d F Y" - "d F Y" - "d-m-Y" - "Y-m-d" - "d/m/Y" - "Y/m/d"');
    }
}
