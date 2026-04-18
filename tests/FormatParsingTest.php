<?php

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

it('parses escaped literals in input format', function () {
    $instance = LaravelNepaliDate::from('2024-02-05z', format: 'Y-m-d\\z', strict: false);

    expect($instance->toNepaliDate())->toBeString();
});
