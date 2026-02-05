<?php

namespace Anuzpandey\LaravelNepaliDate;

use Anuzpandey\LaravelNepaliDate\Exceptions\InvalidDateException;
use Anuzpandey\LaravelNepaliDate\Traits\CalendarDateDataTrait;
use Anuzpandey\LaravelNepaliDate\Traits\DiffForHumansTrait;
use Anuzpandey\LaravelNepaliDate\Traits\EnglishDateTrait;
use Anuzpandey\LaravelNepaliDate\Traits\HelperTrait;
use Anuzpandey\LaravelNepaliDate\Traits\IsLeapYearTrait;
use Anuzpandey\LaravelNepaliDate\Traits\NepaliDateTrait;
use DateTimeInterface;
use InvalidArgumentException;

class LaravelNepaliDate
{
    use CalendarDateDataTrait;
    use DiffForHumansTrait;
    use EnglishDateTrait;
    use HelperTrait;
    use IsLeapYearTrait;
    use NepaliDateTrait;

    private bool $strictValidation;
    private string $inputFormat = 'Y-m-d';
    private ?string $inputDate = null;

    public function __construct(
        public int|string $year,
        public int|string $month,
        public int|string $day,
        ?bool $strictValidation = null,
    ) {
        $this->strictValidation = $strictValidation ?? (bool) config('nepali-date.validation.strict', false);
    }

    public static function from(string|DateTimeInterface $date, string $format = 'Y-m-d', ?bool $strict = null): self
    {
        $strict = $strict ?? (bool) config('nepali-date.validation.strict', false);
        $format = $format ?: 'Y-m-d';

        if ($date instanceof DateTimeInterface) {
            $year = (int) $date->format('Y');
            $month = (int) $date->format('m');
            $day = (int) $date->format('d');
            $inputDate = $date->format('Y-m-d');
        } else {
            $inputDate = $date;
            [$year, $month, $day] = self::parseDateComponents($date, $format);
        }

        $instance = new self($year, $month, $day, $strict);
        $instance->inputFormat = $format;
        $instance->inputDate = $inputDate;

        return $instance;
    }

    public static function validateEnglish(string|DateTimeInterface $date, string $format = 'Y-m-d'): bool
    {
        try {
            if ($date instanceof DateTimeInterface) {
                $year = (int) $date->format('Y');
                $month = (int) $date->format('m');
                $day = (int) $date->format('d');
            } else {
                [$year, $month, $day] = self::parseDateComponents($date, $format);
            }

            $valid = self::assertEnglishComponents($year, $month, $day, true);

            return $valid;
        } catch (InvalidArgumentException $exception) {
            if (self::shouldThrowOnInvalid()) {
                throw $exception;
            }

            return false;
        }
    }

    public static function validateNepali(string $date, string $format = 'Y-m-d'): bool
    {
        try {
            [$year, $month, $day] = self::parseDateComponents($date, $format);

            $valid = self::assertNepaliComponents($year, $month, $day, true);

            return $valid;
        } catch (InvalidArgumentException $exception) {
            if (self::shouldThrowOnInvalid()) {
                throw $exception;
            }

            return false;
        }
    }

    protected function shouldStrictValidate(): bool
    {
        return $this->strictValidation;
    }

    protected function assertEnglishDate(): void
    {
        self::assertEnglishComponents((int) $this->year, (int) $this->month, (int) $this->day, $this->shouldStrictValidate(), self::shouldThrowOnInvalid());
    }

    protected function assertNepaliDate(): void
    {
        self::assertNepaliComponents((int) $this->year, (int) $this->month, (int) $this->day, $this->shouldStrictValidate(), self::shouldThrowOnInvalid());
    }

    protected static function assertEnglishComponents(int $year, int $month, int $day, bool $strict, ?bool $throwOnInvalid = null): bool
    {
        $throwOnInvalid = $throwOnInvalid ?? self::shouldThrowOnInvalid();

        if ($year < 1944 || $year > 2033) {
            self::handleInvalid(self::message('english.out_of_range'), $throwOnInvalid, ['year' => $year, 'month' => $month, 'day' => $day]);

            return false;
        }

        if ($month < 1 || $month > 12) {
            self::handleInvalid(self::message('english.month'), $throwOnInvalid, ['year' => $year, 'month' => $month, 'day' => $day]);

            return false;
        }

        if ($day < 1 || $day > 31) {
            self::handleInvalid(self::message('english.day'), $throwOnInvalid, ['year' => $year, 'month' => $month, 'day' => $day]);

            return false;
        }

        if ($strict && ! checkdate($month, $day, $year)) {
            $message = self::interpolateMessage(self::message('english.invalid_day'), [
                ':year' => $year,
                ':month' => str_pad((string) $month, 2, '0', STR_PAD_LEFT),
            ]);
            self::handleInvalid($message, $throwOnInvalid, ['year' => $year, 'month' => $month, 'day' => $day]);
            return false;
        }

        return true;
    }

    protected static function assertNepaliComponents(int $year, int $month, int $day, bool $strict, ?bool $throwOnInvalid = null): bool
    {
        $throwOnInvalid = $throwOnInvalid ?? self::shouldThrowOnInvalid();

        if ($year < 2000 || $year > 2099) {
            self::handleInvalid(self::message('nepali.out_of_range'), $throwOnInvalid, ['year' => $year, 'month' => $month, 'day' => $day]);

            return false;
        }

        if ($month < 1 || $month > 12) {
            self::handleInvalid(self::message('nepali.month'), $throwOnInvalid, ['year' => $year, 'month' => $month, 'day' => $day]);

            return false;
        }

        if ($day < 1 || $day > 32) {
            self::handleInvalid(self::message('nepali.day'), $throwOnInvalid, ['year' => $year, 'month' => $month, 'day' => $day]);

            return false;
        }

        if ($strict) {
            $daysInMonth = self::daysInMonth($month, $year);

            if ($day > $daysInMonth) {
                $message = self::interpolateMessage(self::message('nepali.invalid_day'), [
                    ':year' => $year,
                    ':month' => str_pad((string) $month, 2, '0', STR_PAD_LEFT),
                    ':max' => $daysInMonth,
                ]);
                self::handleInvalid($message, $throwOnInvalid, ['year' => $year, 'month' => $month, 'day' => $day]);
                return false;
            }
        }

        return true;
    }

    protected static function handleInvalid(string $message, bool $throwOnInvalid, array $context = []): void
    {
        if ($throwOnInvalid) {
            throw InvalidDateException::forDate($message, $context);
        }
    }

    protected static function shouldThrowOnInvalid(): bool
    {
        return (bool) config('nepali-date.validation.throw_on_invalid', true);
    }

    protected static function message(string $key): string
    {
        return match ($key) {
            'format' => config('nepali-date.validation.messages.format', 'Input date does not match the provided format.'),
            'english.out_of_range' => config('nepali-date.validation.messages.english.out_of_range', 'Date is out of range. Please provide date between 1944-01-01 to 2033-12-31'),
            'english.month' => config('nepali-date.validation.messages.english.month', 'Month is out of range. Please provide month between 1-12'),
            'english.day' => config('nepali-date.validation.messages.english.day', 'Day is out of range. Please provide day between 1-31'),
            'english.invalid_day' => config('nepali-date.validation.messages.english.invalid_day', 'Invalid day for :year-:month'),
            'nepali.out_of_range' => config('nepali-date.validation.messages.nepali.out_of_range', 'Date is out of range. Please provide date between 2000 to 2099'),
            'nepali.month' => config('nepali-date.validation.messages.nepali.month', 'Month is out of range. Please provide month between 1-12'),
            'nepali.day' => config('nepali-date.validation.messages.nepali.day', 'Day is out of range. Please provide day between 1-32'),
            'nepali.invalid_day' => config('nepali-date.validation.messages.nepali.invalid_day', 'Invalid day for :year-:month. Max is :max.'),
            default => 'Invalid date.',
        };
    }

    protected static function interpolateMessage(string $message, array $replace): string
    {
        return strtr($message, $replace);
    }

    protected static function parseDateComponents(string $date, string $format): array
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

            if ($char === '\\\\') {
                $escape = true;
                continue;
            }

            if (array_key_exists($char, $tokens)) {
                [$name, $min, $max] = $tokens[$char];

                if (isset($used[$name])) {
                    throw InvalidDateException::forDate('Input format cannot repeat a token.', ['format' => $format]);
                }

                $used[$name] = true;
                $quantifier = $min === $max ? "{{$min}}" : "{{$min},{$max}}";
                $pattern .= "(?P<{$name}>\\d{$quantifier})";
                continue;
            }

            if (ctype_alpha($char)) {
                throw InvalidDateException::forDate('Unsupported input format token.', ['token' => $char, 'format' => $format]);
            }

            $pattern .= preg_quote($char, '/');
        }

        $pattern = '/^'.$pattern.'$/';

        if (! preg_match($pattern, $date, $matches)) {
            throw InvalidDateException::forDate(self::message('format'), ['date' => $date, 'format' => $format]);
        }

        if (! isset($matches['year'], $matches['month'], $matches['day'])) {
            throw InvalidDateException::forDate('Input format must include Y, m, and d tokens.', ['format' => $format]);
        }

        return [
            (int) $matches['year'],
            (int) $matches['month'],
            (int) $matches['day'],
        ];
    }
}
