<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

if (! function_exists('toBS')) {
    /**
     * The function converts a given date string to the Nepali date format
     *
     * @param string date The date parameter is a string that represents the date in the Gregorian
     * calendar format. It should be in the format "YYYY-MM-DD" or "YYYY/MM/DD".
     * @param string format The format parameter is used to specify the desired format of the Nepali
     * date. It is an optional parameter and if not provided, the default format will be used.
     * @param string locale The "locale" parameter is used to specify the language and region
     * @return string Nepali date converted from the given date.
     */
    function toBS(string $date, $format = null, $locale = null): string
    {
        return LaravelNepaliDate::from($date)
            ->toNepaliDate($format ?? 'Y-m-d', $locale ?? 'en');
    }
}
