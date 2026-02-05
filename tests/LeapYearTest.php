<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

it('correctly identifies leap years', function (int $year, bool $expected) {
    $instance = LaravelNepaliDate::from('2000-01-01');
    $reflection = new ReflectionMethod($instance, 'isLeapYear');

    expect($reflection->invoke($instance, $year))->toBe($expected);
})->with([
    [2000, true],   // Divisible by 400
    [1900, false],  // Divisible by 100 but not 400
    [2004, true],   // Divisible by 4
    [2001, false],  // Not divisible by 4
    [2024, true],   // Divisible by 4
    [2023, false],  // Not divisible by 4
    [1600, true],   // Divisible by 400
    [1700, false],  // Divisible by 100 but not 400
    [1800, false],  // Divisible by 100 but not 400
    [2100, false],  // Divisible by 100 but not 400
]);

it('handles leap year february correctly for english dates', function () {
    // Feb 29, 2000 is a leap year
    expect(LaravelNepaliDate::from('2000-02-29')->toNepaliDate())
        ->toBe('2056-11-17');

    // Feb 29, 2004 is a leap year
    expect(LaravelNepaliDate::from('2004-02-29')->toNepaliDate())
        ->toBe('2060-11-17');
});
