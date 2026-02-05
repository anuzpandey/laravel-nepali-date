<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Format
    |--------------------------------------------------------------------------
    |
    | This value defines the default date format used for conversions when
    | no format is explicitly given. You can customize the format string
    | according to their preferences using PHP date format characters.
    |
    | Supported format characters can be found at:
    | https://laravel-nepali-date.anuzpandey.com/docs/formatting/format-strings
    */
    'default_format' => 'Y-m-d',

    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | This value specifies the default locale used for date conversions when
    | no locale is explicitly provided. You can set the locale to 'en' for
    | English or 'np' for Nepali, ascertaining consistent presentation.
    |
    */
    'default_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    |
    | Configure strict validation behavior for date parsing and conversion.
    | When strict is enabled, invalid dates (like 2023-02-30) are rejected.
    | You can disable throwing exceptions if you want boolean validation only.
    |
    */
    'validation' => [
        'strict' => false,
        'throw_on_invalid' => true,
        'messages' => [
            'format' => 'Input date does not match the provided format.',
            'english' => [
                'out_of_range' => 'Date is out of range. Please provide date between 1944-01-01 to 2033-12-31',
                'month' => 'Month is out of range. Please provide month between 1-12',
                'day' => 'Day is out of range. Please provide day between 1-31',
                'invalid_day' => 'Invalid day for :year-:month',
            ],
            'nepali' => [
                'out_of_range' => 'Date is out of range. Please provide date between 2000 to 2099',
                'month' => 'Month is out of range. Please provide month between 1-12',
                'day' => 'Day is out of range. Please provide day between 1-32',
                'invalid_day' => 'Invalid day for :year-:month. Max is :max.',
            ],
        ],
    ],
];
