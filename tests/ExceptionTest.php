<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

// daysInMonth out of range tests - these work correctly
it('throws exception for daysInMonth with year out of range', function () {
    LaravelNepaliDate::daysInMonth(1, 1999);
})->throws(RuntimeException::class, 'Year is out of range');

it('throws exception for daysInYear with year out of range', function () {
    LaravelNepaliDate::daysInYear(1999);
})->throws(RuntimeException::class, 'Year is out of range');

it('throws exception for daysInMonth with year above range', function () {
    LaravelNepaliDate::daysInMonth(1, 2100);
})->throws(RuntimeException::class, 'Year is out of range');

it('throws exception for daysInYear with year above range', function () {
    LaravelNepaliDate::daysInYear(2100);
})->throws(RuntimeException::class, 'Year is out of range');

// Test validation methods directly
it('validates english date range correctly', function () {
    $instance = LaravelNepaliDate::from('2000-01-01');
    $reflection = new ReflectionMethod($instance, 'isInEnglishDateRange');

    // Valid dates return true
    expect($reflection->invoke($instance, 2000, 6, 15))->toBe(true);
    expect($reflection->invoke($instance, 1944, 1, 1))->toBe(true);
    expect($reflection->invoke($instance, 2033, 12, 31))->toBe(true);

    // Invalid year returns error string
    expect($reflection->invoke($instance, 1943, 1, 1))->toBeString()
        ->toContain('Date is out of range');
    expect($reflection->invoke($instance, 2034, 1, 1))->toBeString()
        ->toContain('Date is out of range');

    // Invalid month returns error string
    expect($reflection->invoke($instance, 2000, 0, 1))->toBeString()
        ->toContain('Month is out of range');
    expect($reflection->invoke($instance, 2000, 13, 1))->toBeString()
        ->toContain('Month is out of range');

    // Invalid day returns error string
    expect($reflection->invoke($instance, 2000, 1, 0))->toBeString()
        ->toContain('Day is out of range');
    expect($reflection->invoke($instance, 2000, 1, 32))->toBeString()
        ->toContain('Day is out of range');
});

it('validates nepali date range correctly', function () {
    $instance = LaravelNepaliDate::from('2050-01-01');

    // Valid dates return true
    expect($instance->isInNepaliDateRange(2050, 6, 15))->toBe(true);
    expect($instance->isInNepaliDateRange(2000, 1, 1))->toBe(true);
    expect($instance->isInNepaliDateRange(2089, 12, 30))->toBe(true);

    // Invalid year returns error string
    expect($instance->isInNepaliDateRange(1999, 1, 1))->toBeString()
        ->toContain('Date is out of range');
    expect($instance->isInNepaliDateRange(2090, 1, 1))->toBeString()
        ->toContain('Date is out of range');

    // Invalid month returns error string
    expect($instance->isInNepaliDateRange(2050, 0, 1))->toBeString()
        ->toContain('Month is out of range');
    expect($instance->isInNepaliDateRange(2050, 13, 1))->toBeString()
        ->toContain('Month is out of range');

    // Invalid day returns error string
    expect($instance->isInNepaliDateRange(2050, 1, 0))->toBeString()
        ->toContain('Day is out of range');
    expect($instance->isInNepaliDateRange(2050, 1, 33))->toBeString()
        ->toContain('Day is out of range');
});
