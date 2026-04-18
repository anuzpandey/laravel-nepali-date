<?php

namespace Anuzpandey\LaravelNepaliDate\Console\Commands;

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use Illuminate\Console\Command;
use InvalidArgumentException;

abstract class BaseNepaliDateCommand extends Command
{
    protected function normalizeCalendar(?string $value, string $optionName = 'calendar'): string
    {
        $value = strtolower(trim((string) $value));

        if ($value === '') {
            return 'en';
        }

        if (! in_array($value, ['en', 'np'], true)) {
            throw new InvalidArgumentException("Invalid {$optionName} value [{$value}]. Use 'en' or 'np'.");
        }

        return $value;
    }

    protected function normalizeLocale(?string $value): string
    {
        $value = strtolower(trim((string) $value));

        if ($value === '') {
            return config('nepali-date.default_locale');
        }

        if (! in_array($value, ['en', 'np'], true)) {
            throw new InvalidArgumentException("Invalid locale value [{$value}]. Use 'en' or 'np'.");
        }

        return $value;
    }

    protected function resolveFormat(?string $value): string
    {
        return $value ?: config('nepali-date.default_format');
    }

    protected function parseDateString(string $date, string $format): array
    {
        $tokens = [
            'Y' => ['year', 4, 4],
            'm' => ['month', 2, 2],
            'n' => ['month', 1, 2],
            'd' => ['day', 2, 2],
            'j' => ['day', 1, 2],
        ];

        $pattern = '';
        $used = [];
        $escape = false;
        $length = strlen($format);

        for ($i = 0; $i < $length; $i++) {
            $char = $format[$i];

            if ($escape) {
                $pattern .= preg_quote($char, '/');
                $escape = false;

                continue;
            }

            if ($char === '\\') {
                $escape = true;

                continue;
            }

            if (array_key_exists($char, $tokens)) {
                [$name, $min, $max] = $tokens[$char];

                if (isset($used[$name])) {
                    throw new InvalidArgumentException("Input format cannot repeat [{$name}] token.");
                }

                $used[$name] = true;
                $quantifier = $min === $max ? "{{$min}}" : "{{$min},{$max}}";
                $pattern .= "(?P<{$name}>\\d{$quantifier})";

                continue;
            }

            if (ctype_alpha($char)) {
                throw new InvalidArgumentException("Unsupported input format token [{$char}].");
            }

            $pattern .= preg_quote($char, '/');
        }

        $pattern = '/^'.$pattern.'$/';

        if (! preg_match($pattern, $date, $matches)) {
            throw new InvalidArgumentException('Input date does not match the provided format.');
        }

        if (! isset($matches['year'], $matches['month'], $matches['day'])) {
            throw new InvalidArgumentException('Input format must include Y, m, and d tokens.');
        }

        return [
            'year' => (int) $matches['year'],
            'month' => (int) $matches['month'],
            'day' => (int) $matches['day'],
        ];
    }

    protected function normalizeDate(int $year, int $month, int $day): string
    {
        return sprintf('%04d-%02d-%02d', $year, $month, $day);
    }

    protected function validateDateRange(string $calendar, int $year, int $month, int $day): void
    {
        if ($calendar === 'en') {
            if ($year < 1944 || $year > 2033) {
                throw new InvalidArgumentException('Date is out of range. Please provide date between 1944-01-01 to 2033-12-31');
            }

            if ($month < 1 || $month > 12) {
                throw new InvalidArgumentException('Month is out of range. Please provide month between 1-12');
            }

            if ($day < 1 || $day > 31) {
                throw new InvalidArgumentException('Day is out of range. Please provide day between 1-31');
            }

            return;
        }

        if ($year < 2000 || $year > 2099) {
            throw new InvalidArgumentException('Date is out of range. Please provide date between 2000 to 2099');
        }

        if ($month < 1 || $month > 12) {
            throw new InvalidArgumentException('Month is out of range. Please provide month between 1-12');
        }

        if ($day < 1 || $day > 32) {
            throw new InvalidArgumentException('Day is out of range. Please provide day between 1-32');
        }
    }

    protected function validateStrictDate(string $calendar, int $year, int $month, int $day): void
    {
        if ($calendar === 'en') {
            if (! checkdate($month, $day, $year)) {
                throw new InvalidArgumentException("Invalid day for {$year}-".sprintf('%02d', $month));
            }

            return;
        }

        $daysInMonth = LaravelNepaliDate::daysInMonth($month, $year);

        if ($day > $daysInMonth) {
            throw new InvalidArgumentException("Invalid day for {$year}-".sprintf('%02d', $month).". Max is {$daysInMonth}.");
        }
    }

    protected function parseInputDate(string $date, string $format, string $calendar, bool $strict): array
    {
        $parts = $this->parseDateString($date, $format);
        $year = $parts['year'];
        $month = $parts['month'];
        $day = $parts['day'];

        $this->validateDateRange($calendar, $year, $month, $day);

        if ($strict) {
            $this->validateStrictDate($calendar, $year, $month, $day);
        }

        return [$year, $month, $day, $this->normalizeDate($year, $month, $day)];
    }

    protected function formatEnglishDate(string $englishDate, string $format, string $locale): string
    {
        if ($format === 'Y-m-d' && $locale === 'en') {
            return $englishDate;
        }

        $nepaliDate = LaravelNepaliDate::from($englishDate)->toNepaliDate('Y-m-d', 'en');

        return LaravelNepaliDate::from($nepaliDate)->toEnglishDate($format, $locale);
    }
}
