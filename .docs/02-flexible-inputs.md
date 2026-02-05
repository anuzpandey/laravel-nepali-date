# Flexible Input Parsing

`LaravelNepaliDate::from()` supports multiple input types to reduce friction when integrating with Laravel models and common date sources, while still protecting Nepali (BS) input from Gregorian-only date objects.

## Supported Inputs
- `string` date in a specified format.
- `DateTimeInterface` (including Carbon) for English (AD) input only.
- Unix timestamp as `int` or numeric string for English (AD) input only.
- Array with keys `year`, `month`, `day`.

## API
- `LaravelNepaliDate::from(mixed $input, string $format = 'Y-m-d', string $calendar = 'en', bool $strict = false)`
- `LaravelNepaliDate::parse(mixed $input, array $options = [])`

## Examples
```php
use Carbon\Carbon;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

LaravelNepaliDate::from('1996-04-22')->toNepaliDate();
LaravelNepaliDate::from('22/04/1996', format: 'd/m/Y')->toNepaliDate();

$carbon = Carbon::parse('1996-04-22');
LaravelNepaliDate::from($carbon)->toNepaliDate(); // AD input

LaravelNepaliDate::from(829632000)->toNepaliDate(); // AD timestamp

LaravelNepaliDate::from(['year' => 1996, 'month' => 4, 'day' => 22])->toNepaliDate();

// Nepali input should be string, not Carbon
LaravelNepaliDate::from('2080-01-01', calendar: 'np')->toEnglishDate();
```

## Options
- `calendar` tells the parser whether input is English (`en`) or Nepali (`np`).
- `format` is used only for string inputs.
- `strict` enables strict validation (throws on invalid dates).

## Notes
- `DateTimeInterface` and timestamps are supported only for English input.
- If `calendar=np` and the input is `DateTimeInterface` or a timestamp, `InvalidDateException` is thrown.
- Parsing errors throw `InvalidDateException` with details about the input and expected format.
