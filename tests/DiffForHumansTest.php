<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

it('converts diff for humans to nepali format', function (string $input, string $expected) {
    $instance = LaravelNepaliDate::from('2000-01-01');

    expect($instance->nepaliDiffForHumans($input))->toBe($expected);
})->with([
    ['1 year ago', '१ वर्ष पहिले'],
    ['2 years ago', '२ वर्ष पहिले'],
    ['1 month ago', '१ महिना पहिले'],
    ['5 months ago', '५ महिना पहिले'],
    ['1 day ago', '१ दिन पहिले'],
    ['10 days ago', '१० दिन पहिले'],
    ['1 week ago', '१ हप्ता पहिले'],
    ['3 weeks ago', '३ हप्ता पहिले'],
    ['1 hour ago', '१ घण्टा पहिले'],
    ['12 hours ago', '१२ घण्टा पहिले'],
    ['1 minute ago', '१ मिनेट पहिले'],
    ['30 minutes ago', '३० मिनेट पहिले'],
    ['1 second ago', '१ सेकेन्ड पहिले'],
    ['45 seconds ago', '४५ सेकेन्ड पहिले'],
    ['1 year from now', '१ वर्ष पछि'],
    ['2 days from now', '२ दिन पछि'],
]);

it('converts numbers to nepali format', function () {
    $instance = LaravelNepaliDate::from('2000-01-01');

    expect($instance->convertEnToNpNumber('0123456789'))->toBe('०१२३४५६७८९');
    expect($instance->convertEnToNpNumber('2080'))->toBe('२०८०');
    expect($instance->convertEnToNpNumber('15'))->toBe('१५');
});

it('converts words to nepali format', function () {
    $instance = LaravelNepaliDate::from('2000-01-01');

    expect($instance->convertEnToNpWord('years'))->toBe('वर्ष');
    expect($instance->convertEnToNpWord('months'))->toBe('महिना');
    expect($instance->convertEnToNpWord('days'))->toBe('दिन');
    expect($instance->convertEnToNpWord('ago'))->toBe('पहिले');
    expect($instance->convertEnToNpWord('from now'))->toBe('पछि');
});
