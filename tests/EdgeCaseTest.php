<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

// Boundary date tests for English to Nepali conversion
it('can convert earliest supported english date', function () {
    expect(LaravelNepaliDate::from('1944-01-01')->toNepaliDate())
        ->toBe('2000-09-17');
});

it('can convert latest supported english date', function () {
    expect(LaravelNepaliDate::from('2033-12-31')->toNepaliDate())
        ->toBe('2090-09-16');
});

// Boundary date tests for Nepali to English conversion
it('can convert earliest supported nepali date', function () {
    expect(LaravelNepaliDate::from('2000-09-17')->toEnglishDate())
        ->toBe('1944-01-01');
});

it('can convert latest supported nepali date', function () {
    expect(LaravelNepaliDate::from('2090-09-16')->toEnglishDate())
        ->toBe('2033-12-31');
});

// Year boundary tests
it('can handle year transition for english to nepali', function () {
    expect(LaravelNepaliDate::from('1999-12-31')->toNepaliDate())
        ->toBe('2056-09-16');

    expect(LaravelNepaliDate::from('2000-01-01')->toNepaliDate())
        ->toBe('2056-09-17');
});

it('can handle year transition for nepali to english', function () {
    expect(LaravelNepaliDate::from('2056-12-30')->toEnglishDate())
        ->toBe('2000-04-12');

    expect(LaravelNepaliDate::from('2057-01-01')->toEnglishDate())
        ->toBe('2000-04-13');
});

// Month boundary tests
it('can handle month with 32 days in nepali calendar', function () {
    // Jestha 2081 has 32 days
    expect(LaravelNepaliDate::from('2081-02-32')->toEnglishDate())
        ->toBe('2024-06-14');
});

it('can handle first day of each month', function () {
    expect(LaravelNepaliDate::from('2080-01-01')->toEnglishDate())
        ->toBe('2023-04-14');

    expect(LaravelNepaliDate::from('2080-06-01')->toEnglishDate())
        ->toBe('2023-09-18');

    expect(LaravelNepaliDate::from('2080-12-01')->toEnglishDate())
        ->toBe('2024-03-14');
});
