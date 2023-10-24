<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

it('can convert to basic nepali date', function () {
    $date = '1996-04-22';

    $nepaliDate = LaravelNepaliDate::from($date)->toNepaliDate();

    expect($nepaliDate)
        ->toBe('2053-01-10');
});

it('can convert to date array', function () {
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

it('can convert to formatted result', function (string $format, string $locale, string $expectedResult) {
    $date = '1996-04-22';

    expect(LaravelNepaliDate::from($date)->toFormattedNepaliDate(format: $format, locale: $locale))
        ->toBe($expectedResult);
})->with([
    ["d F Y, l", "np", "१० वैशाख २०५३, सोमबार"],
    ["d F Y, l", "en", "10 Baisakh 2053, Monday"],
    ["Y-m-d", "np", "२०५३-०१-१०"],
    ["Y-m-d", "en", "2053-01-10"],
    ["l, d F Y", "np", "सोमबार, १० वैशाख २०५३"],
    ["l, d F Y", "en", "Monday, 10 Baisakh 2053"],
    ["d F Y",  "np", "१० वैशाख २०५३"],
    ["d F Y", "en", "10 Baisakh 2053"],
    ["Y/m/d", "np", "२०५३/०१/१०"]
]);
