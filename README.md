# A Laravel Package to convert Dates from BS and AD.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/anuzpandey/laravel-nepali-date.svg?style=flat-square)](https://packagist.org/packages/anuzpandey/laravel-nepali-date)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/anuzpandey/laravel-nepali-date/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/anuzpandey/laravel-nepali-date/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/anuzpandey/laravel-nepali-date.svg?style=flat-square)](https://packagist.org/packages/anuzpandey/laravel-nepali-date)

LaravelNepaliDate is a Laravel package that simplifies the conversion of dates between the Gregorian (English) and Nepali (Bikram Sambat) calendars. This package is a handy tool for projects that require handling dates in both English and Nepali formats, such as websites and applications targeting users in Nepal.

## Installation

You can install the package via composer:

```bash
composer require anuzpandey/laravel-nepali-date
```

Optionally, you can publish the config file with:

```bash
php artisan vendor:publish --tag="nepali-date-config"
```

## Usage

```php
$engDate = '1996-04-22';
LaravelNepaliDate::from($engDate)->toNepaliDate();
// Result: 2053-01-10

LaravelNepaliDate::from($engDate)->toNepaliDate(format: 'D, j F Y');
// Result: सोम, १० वैशाख २०५३

// Format Specifiers are supported and listed below
LaravelNepaliDate::from($engDate)->toNepaliDate(format: 'D, j F Y', locale: 'en');
// Result: Mon, 10 Baisakh 2053


$nepDate = '2053-01-10';
LaravelNepaliDate::from($nepDate)->toEnglishDate();
// Result: 1996-04-22

LaravelNepaliDate::from($nepDate)->toEnglishDate(format: 'l, jS F Y');
// Result: Sunday, 22nd April 1996

// Format Specifiers are supported and listed below
LaravelNepaliDate::from($nepDate)->toEnglishDate(format: 'l, j F Y', locale: 'np');
// Result: आइतबार, २२ बैशाख १९९६

// Get total days in a month of a year
use Anuzpandey\LaravelNepaliDate\Enums\NepaliMonth;
// month can be NepaliMonth::XXX or month number (1-12)
LaravelNepaliDate::daysInMonth(NepaliMonth::BAISAKH, 2053);
// Result: 31

// Get total days in a year
LaravelNepaliDate::daysInYear(2053);
// Result: 365
```

## Format Specifiers

The following format specifiers are supported for formatting dates:

- `Y` - Year in four digits
- `y` - Year in two digits
- `m` - Month in two digits with leading zero (01-12/०१-१२)
- `n` - Month in one or two digits without leading zero (1-12/१-१२)
- `M` - Month in three letters (Jan-Dec)
- `F` - Month in full name (January-December/बैशाख-चैत्र)
- `d` - Day in two digits with leading zero (01-31/०१-३२)
- `j` - Day in one or two digits without leading zero (1-31/१-३२)
- `D` - Day in three letters (Sun-Sat/आइत-शनि)
- `l` - Day in full name (Sunday-Saturday/आइतबार-शनिबार)
- `S` - Day in two letters (st, nd, rd, th)

## Extending Carbon with NepaliDateMixin
> **Note:** This feature has been deprecated as Carbon doesn't support the months having more than 31 days. This feature has been removed from version 2.0.0.

### Helper function

```php
// Convert English date to Nepali date (B.S.).
toNepaliDate("1996-04-22") 
// Result: 2053-01-10

// Convert Nepali date to English date (A.D.).
toEnglishDate("2053-01-10") 
// Result: 1996-04-22
```

## Blade Directives

You can use the Blade directives directly in your views:

```blade
{{-- Convert English date to Nepali date --}}
@nepaliDate('1996-04-22')
{{-- Result: 2053-01-10 --}}

{{-- With format --}}
@nepaliDate('1996-04-22', 'l, d F Y')
{{-- Result: सोमबार, १० वैशाख २०५३ --}}

{{-- With format and locale --}}
@nepaliDate('1996-04-22', 'l, d F Y', 'en')
{{-- Result: Monday, 10 Baisakh 2053 --}}

{{-- Convert Nepali date to English date --}}
@englishDate('2053-01-10')
{{-- Result: 1996-04-22 --}}

{{-- With format --}}
@englishDate('2053-01-10', 'l, d F Y')
{{-- Result: सोमबार, २२ अप्रिल १९९६ --}}

{{-- With format and locale --}}
@englishDate('2053-01-10', 'l, d F Y', 'en')
{{-- Result: Monday, 22 April 1996 --}}
```

## Getting Date as Array

You can get the date components as an array for more flexibility:

```php
$engDate = '1996-04-22';
$dateArray = LaravelNepaliDate::from($engDate)->toNepaliDateArray();
// Returns NepaliDateArrayData object with:
// - year: '2053'
// - month: '01'
// - day: '10'
// - npYear: '२०५३'
// - npMonth: '०१'
// - npDay: '१०'
// - dayName: 'Monday'
// - monthName: 'Baisakh'
// - npDayName: 'सोमबार'
// - npMonthName: 'वैशाख'

$nepDate = '2053-01-10';
$dateArray = LaravelNepaliDate::from($nepDate)->toEnglishDateArray();
// Returns similar structure with English date data
```

## Supported Date Ranges

| Calendar | From | To |
|----------|------|-----|
| English (A.D.) | 1944-01-01 | 2033-12-31 |
| Nepali (B.S.) | 2000-09-17 | 2099-12-30 |

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [AnuzPandey](https://github.com/anuzpandey)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
