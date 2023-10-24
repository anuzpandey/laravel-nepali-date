<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

it('can convert to basic nepali date', function (string $date, string $expectedResult) {
    $nepaliDate = LaravelNepaliDate::from($date)->toNepaliDate();

    expect($nepaliDate)
        ->toBe($expectedResult);
})->with([
    ['1996-04-22', '2053-01-10'],
    ['1972-07-19', '2029-04-04'],
    ['1966-04-02', '2022-12-20'],
]);

it('can convert to nepali date array', function () {
    $date = '1996-04-22';

    $nepaliDateArray = LaravelNepaliDate::from($date)->toNepaliDateArray();

    expect($nepaliDateArray->toArray())
        ->toBeArray()
        ->toMatchArray([
            'year' => '2053',
            'month' => '01',
            'day' => '10',
            'npYear' => '२०५३',
            'npDayName' => 'सोमबार',
        ]);
});

it('can convert to nepali formatted result', function (string $format, string $locale, string $expectedResult) {
    $date = '1996-04-22';

    expect(LaravelNepaliDate::from($date)->toFormattedNepaliDate(format: $format, locale: $locale))
        ->toBe($expectedResult);
})->with([
    ['d F Y, l', 'np', '१० वैशाख २०५३, सोमबार'],
    ['d F Y, l', 'en', '10 Baisakh 2053, Monday'],
    ['Y-m-d', 'np', '२०५३-०१-१०'],
    ['Y-m-d', 'en', '2053-01-10'],
    ['l, d F Y', 'np', 'सोमबार, १० वैशाख २०५३'],
    ['l, d F Y', 'en', 'Monday, 10 Baisakh 2053'],
    ['d F Y', 'np', '१० वैशाख २०५३'],
    ['d F Y', 'en', '10 Baisakh 2053'],
    ['Y/m/d', 'np', '२०५३/०१/१०'],
]);
