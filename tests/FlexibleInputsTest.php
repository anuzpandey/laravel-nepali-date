<?php

use Anuzpandey\LaravelNepaliDate\Exceptions\InvalidDateException;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use Carbon\Carbon;

it('accepts array input', function () {
    $result = LaravelNepaliDate::from(['year' => 1996, 'month' => 4, 'day' => 22])->toNepaliDate();

    expect($result)->toBe(LaravelNepaliDate::from('1996-04-22')->toNepaliDate());
});

it('accepts timestamp input for english calendar', function () {
    config()->set('app.timezone', 'UTC');

    $timestamp = (new DateTimeImmutable('1996-04-22 00:00:00', new DateTimeZone('UTC')))->getTimestamp();
    $result = LaravelNepaliDate::from($timestamp)->toNepaliDate();

    expect($result)->toBe(LaravelNepaliDate::from('1996-04-22')->toNepaliDate());
});

it('accepts numeric string timestamp input for english calendar', function () {
    config()->set('app.timezone', 'UTC');

    $timestamp = (string) (new DateTimeImmutable('1996-04-22 00:00:00', new DateTimeZone('UTC')))->getTimestamp();
    $result = LaravelNepaliDate::from($timestamp)->toNepaliDate();

    expect($result)->toBe(LaravelNepaliDate::from('1996-04-22')->toNepaliDate());
});

it('rejects DateTimeInterface input for nepali calendar', function () {
    $date = Carbon::parse('1996-04-22');

    LaravelNepaliDate::from($date, calendar: 'np')->toEnglishDate();
})->throws(InvalidDateException::class, 'DateTimeInterface inputs are only supported for English dates.');

it('rejects timestamp input for nepali calendar', function () {
    LaravelNepaliDate::from(829632000, calendar: 'np')->toEnglishDate();
})->throws(InvalidDateException::class, 'Timestamp inputs are only supported for English dates.');

it('supports parse helper with options', function () {
    $result = LaravelNepaliDate::parse('22/04/1996', ['format' => 'd/m/Y'])->toNepaliDate();

    expect($result)->toBe(LaravelNepaliDate::from('1996-04-22')->toNepaliDate());
});

it('parses numeric date strings with a custom format', function () {
    $result = LaravelNepaliDate::from('19960422', format: 'Ymd')->toNepaliDate();

    expect($result)->toBe(LaravelNepaliDate::from('1996-04-22')->toNepaliDate());
});

it('parses numeric nepali date strings with a custom format', function () {
    $result = LaravelNepaliDate::from('20800101', format: 'Ymd', calendar: 'np')->toEnglishDate();

    expect($result)->toBe(LaravelNepaliDate::from('2080-01-01', calendar: 'np')->toEnglishDate());
});

it('does not treat short numeric strings as timestamps when format mismatches', function () {
    LaravelNepaliDate::from('19960422')->toNepaliDate();
})->throws(InvalidDateException::class, 'Input date does not match the provided format.');
