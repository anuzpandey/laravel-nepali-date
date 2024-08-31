<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

if (! function_exists('toNepaliDate')) {
    /**
     * The function converts a given date to the Nepali date format
     *
     * @param string $date <p>The date parameter is a string that represents the date in the English calendar format.</p>
     * @param string|null $format <p>The format parameter is used to specify the desired format of the Nepali date.</p>
     * @param string|null $locale <p>The "locale" parameter is used to specify the language and region. Supported languages are <i>en</i> and <i>np</i></p>
     * @return string <p>Nepali date converted from the given English Date.</p>
     */
    function toNepaliDate(string $date, ?string $format = null, ?string $locale = null): string
    {
        return LaravelNepaliDate::from($date)
            ->toNepaliDate(
                $format ?? config('nepali-date.default_format'),
                $locale ?? config('nepali-date.default_locale')
            );
    }
}

if (! function_exists('toEnglishDate')) {
    /**
     * The function converts a given date to the English date format
     *
     * @param string $date <p>The date parameter is a string that represents the date in the Nepali calendar format.</p>
     * @param string|null $format <p>The format parameter is used to specify the desired format of the English date.</p>
     * @param string|null $locale <p>The "locale" parameter is used to specify the language and region. Supported languages are <i>en</i> and <i>np</i></p>
     * @return string <p>English date converted from the given Nepali Date.</p>
     */
    function toEnglishDate(string $date, ?string $format = null, ?string $locale = null): string
    {
        return LaravelNepaliDate::from($date)
            ->toEnglishDate(
                $format ?? config('nepali-date.default_format'),
                $locale ?? config('nepali-date.default_locale')
            );
    }
}
