<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

it('can convert to basic nepali date', function (string $date, string $expectedResult) {
    $nepaliDate = LaravelNepaliDate::from($date)->toEnglishDate();

    expect($nepaliDate)
        ->toBe($expectedResult);
})->with([
    ['2053-01-10', '1996-04-22'],
    ['2029-04-04', '1972-07-19'],
    ['2022-12-20', '1966-04-02'],
]);


it('can convert to nepali formatted result', function (string $format, string $locale, string $expectedResult) {
    $date = '2053-01-10';

    expect(LaravelNepaliDate::from($date)->toEnglishDate(format: $format, locale: $locale))
        ->toBe($expectedResult);
})->with([
    ['d F Y, l', 'np', '२२ अप्रिल १९९६, सोमबार'],
    ['d F Y, l', 'en', '22 April 1996, Monday'],
    ['Y-m-d', 'np', '१९९६-०४-२२'],
    ['Y-m-d', 'en', '1996-04-22'],
    ['l, d F Y', 'np', 'सोमबार, २२ अप्रिल १९९६'],
    ['l, d F Y', 'en', 'Monday, 22 April 1996'],
    ['d F Y', 'np', '२२ अप्रिल १९९६'],
    ['d F Y', 'en', '22 April 1996'],
    ['Y/m/d', 'np', '१९९६/०४/२२'],
]);

it('can convert to basic nepali date to english date with helper function', function (string $date, string $expectedResult) {
    expect(toEnglishDate($date))
        ->toBe($expectedResult);
})->with([
    ['2053-01-10', '1996-04-22'],
    ['2029-04-04', '1972-07-19'],
    ['2022-12-20', '1966-04-02'],
]);


it('can convert to nepali formatted result to english date with helper function', function (string $format, string $locale, string $expectedResult) {
    expect(toEnglishDate("2053-01-10", $format, $locale))
        ->toBe($expectedResult);
})->with([
    ['d F Y, l', 'np', '२२ अप्रिल १९९६, सोमबार'],
    ['d F Y, l', 'en', '22 April 1996, Monday'],
    ['Y-m-d', 'np', '१९९६-०४-२२'],
    ['Y-m-d', 'en', '1996-04-22'],
    ['l, d F Y', 'np', 'सोमबार, २२ अप्रिल १९९६'],
    ['l, d F Y', 'en', 'Monday, 22 April 1996'],
    ['d F Y', 'np', '२२ अप्रिल १९९६'],
    ['d F Y', 'en', '22 April 1996'],
    ['Y/m/d', 'np', '१९९६/०४/२२'],
]);
