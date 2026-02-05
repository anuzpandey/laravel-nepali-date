<?php

namespace Anuzpandey\LaravelNepaliDate\Console\Commands;

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use InvalidArgumentException;
use RuntimeException;

class ConvertNepaliDateCommand extends BaseNepaliDateCommand
{
    protected $signature = 'nepali-date:convert
        {--from= : Input date (required)}
        {--to= : Target calendar en|np (required)}
        {--input-format=Y-m-d : Input date format}
        {--calendar=en : Input calendar en|np}
        {--format= : Output format}
        {--locale= : Output locale en|np}
        {--strict : Enable strict date validation}
        {--json : Emit machine-readable JSON output}
        {--timezone= : Timezone for datetime parsing}';

    protected $description = 'Convert a single date between Nepali (BS) and English (AD) calendars.';

    public function handle(): int
    {
        try {
            $from = $this->option('from');
            $targetCalendar = $this->normalizeCalendar($this->option('to'), 'to');
            $inputCalendar = $this->normalizeCalendar($this->option('calendar'), 'calendar');

            if (! $from) {
                throw new InvalidArgumentException('The --from option is required.');
            }

            if ($inputCalendar === $targetCalendar) {
                throw new InvalidArgumentException('Input and output calendars must be different.');
            }

            $format = $this->resolveFormat($this->option('format'));
            $locale = $this->normalizeLocale($this->option('locale'));
            $inputFormat = $this->option('input-format') ?: 'Y-m-d';
            $strict = (bool) $this->option('strict');

            [$year, $month, $day, $inputDate] = $this->parseInputDate($from, $inputFormat, $inputCalendar, $strict);

            if ($targetCalendar === 'np') {
                $outputDate = LaravelNepaliDate::from($inputDate)->toNepaliDate('Y-m-d', 'en');
                $formatted = LaravelNepaliDate::from($inputDate)->toNepaliDate($format, $locale);
            } else {
                $outputDate = LaravelNepaliDate::from($inputDate)->toEnglishDate('Y-m-d', 'en');
                $formatted = LaravelNepaliDate::from($inputDate)->toEnglishDate($format, $locale);
            }

            if ($this->option('json')) {
                $payload = [
                    'input' => $inputDate,
                    'input_calendar' => $inputCalendar,
                    'output' => $outputDate,
                    'output_calendar' => $targetCalendar,
                    'formatted' => $formatted,
                    'format' => $format,
                    'locale' => $locale,
                ];

                $this->line(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                return self::SUCCESS;
            }

            if ($this->option('quiet')) {
                $this->line($outputDate);

                return self::SUCCESS;
            }

            $this->line("Input: {$inputDate} ({$inputCalendar})");
            $this->line("Output: {$outputDate} ({$targetCalendar})");
            $this->line("Formatted: {$formatted}");

            return self::SUCCESS;
        } catch (InvalidArgumentException | RuntimeException $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }
    }
}
