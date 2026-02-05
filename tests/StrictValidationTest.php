<?php

use Anuzpandey\LaravelNepaliDate\Exceptions\InvalidDateException;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use Carbon\Carbon;

it('validates english dates strictly', function () {
    config()->set('nepali-date.validation.throw_on_invalid', false);

    expect(LaravelNepaliDate::validateEnglish('2024-02-29'))->toBeTrue();
    expect(LaravelNepaliDate::validateEnglish('2023-02-29'))->toBeFalse();
});

it('throws on invalid english date when configured', function () {
    config()->set('nepali-date.validation.throw_on_invalid', true);

    LaravelNepaliDate::validateEnglish('2023-02-29');
})->throws(InvalidDateException::class, 'Invalid day for 2023-02');

it('throws on invalid english date during strict conversion even when throw_on_invalid is false', function () {
    config()->set('nepali-date.validation.throw_on_invalid', false);

    LaravelNepaliDate::from('2023-02-29', strict: true)->toNepaliDate();
})->throws(InvalidDateException::class, 'Invalid day for 2023-02');

it('validates nepali dates strictly', function () {
    config()->set('nepali-date.validation.throw_on_invalid', false);

    expect(LaravelNepaliDate::validateNepali('2081-02-32'))->toBeTrue();
    expect(LaravelNepaliDate::validateNepali('2081-02-33'))->toBeFalse();
});

it('throws on invalid nepali date when strict conversion is enabled', function () {
    config()->set('nepali-date.validation.throw_on_invalid', true);

    LaravelNepaliDate::from('2081-01-32', strict: true)->toEnglishDate();
})->throws(InvalidDateException::class, 'Invalid day for 2081-01. Max is 31.');

it('allows non-strict conversions for invalid day values', function () {
    config()->set('nepali-date.validation.throw_on_invalid', true);

    $result = LaravelNepaliDate::from('2023-02-30', strict: false)->toNepaliDate();

    expect($result)->toBeString();
});

it('accepts DateTimeInterface for english validation', function () {
    config()->set('nepali-date.validation.throw_on_invalid', false);

    $date = Carbon::create(2024, 2, 29, 0, 0, 0, 'UTC');

    expect(LaravelNepaliDate::validateEnglish($date))->toBeTrue();
});
