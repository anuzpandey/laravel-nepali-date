<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

it('preserves time when converting english date time to nepali', function () {
    $result = LaravelNepaliDate::from('1996-04-22 12:30:15', format: 'Y-m-d H:i:s')
        ->toNepaliDateTime('Y-m-d H:i:s', 'en');

    expect($result)->toBe('2053-01-10 12:30:15');
});

it('preserves time when converting nepali date time to english', function () {
    $result = LaravelNepaliDate::from('2053-01-10 12:30:15', format: 'Y-m-d H:i:s', calendar: 'np')
        ->toEnglishDateTime('Y-m-d H:i:s', 'en');

    expect($result)->toBe('1996-04-22 12:30:15');
});

it('defaults time to midnight when input has no time component', function () {
    $result = LaravelNepaliDate::from('1996-04-22')->toNepaliDateTime('H:i:s', 'en');

    expect($result)->toBe('00:00:00');
});

it('keeps time numeric even for nepali locale output', function () {
    $result = LaravelNepaliDate::from('1996-04-22 09:08:07', format: 'Y-m-d H:i:s')
        ->toNepaliDateTime('Y-m-d H:i:s', 'np');

    expect($result)->toBe('२०५३-०१-१० 09:08:07');
});

it('returns today for english calendar with midnight time', function () {
    config()->set('app.timezone', 'UTC');
    $today = (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->format('Y-m-d');

    $instance = LaravelNepaliDate::today('en');

    expect($instance->toNepaliDate('Y-m-d', 'en'))->toBe(LaravelNepaliDate::from($today)->toNepaliDate('Y-m-d', 'en'));
    expect($instance->toNepaliDateTime('H:i:s', 'en'))->toBe('00:00:00');
});

it('returns today for nepali calendar with midnight time', function () {
    config()->set('app.timezone', 'UTC');

    $instance = LaravelNepaliDate::today('np');

    expect($instance->toEnglishDateTime('H:i:s', 'en'))->toBe('00:00:00');
});

it('returns now for english calendar with time-of-day', function () {
    config()->set('app.timezone', 'UTC');

    $instance = LaravelNepaliDate::now('en');

    expect($instance->toNepaliDateTime('H:i:s', 'en'))->toMatch('/^\d{2}:\d{2}:\d{2}$/');
});

it('returns now for nepali calendar with time-of-day', function () {
    config()->set('app.timezone', 'UTC');

    $instance = LaravelNepaliDate::now('np');

    expect($instance->toEnglishDateTime('H:i:s', 'en'))->toMatch('/^\d{2}:\d{2}:\d{2}$/');
});
