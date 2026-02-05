<?php

namespace Anuzpandey\LaravelNepaliDate\Console\Commands;

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use Carbon\Carbon;
use InvalidArgumentException;
use RuntimeException;

class TodayNepaliDateCommand extends BaseNepaliDateCommand
{
    protected $signature = 'nepali-date:today
        {--calendar=en : Primary output calendar en|np}
        {--format= : Output format}
        {--locale= : Output locale en|np}
        {--strict : Enable strict date validation}
        {--json : Emit machine-readable JSON output}
        {--timezone= : Timezone for today output}';

    protected $description = 'Show today in both Nepali (BS) and English (AD) calendars.';

    public function handle(): int
    {
        try {
            $primaryCalendar = $this->normalizeCalendar($this->option('calendar'), 'calendar');
            $format = $this->resolveFormat($this->option('format'));
            $locale = $this->normalizeLocale($this->option('locale'));
            $timezone = $this->option('timezone') ?: config('app.timezone');

            $today = Carbon::now($timezone ?? 'UTC');
            $englishDate = $today->format('Y-m-d');

            $nepaliDate = LaravelNepaliDate::from($englishDate)->toNepaliDate('Y-m-d', 'en');

            $englishFormatted = $this->formatEnglishDate($englishDate, $format, $locale);
            $nepaliFormatted = LaravelNepaliDate::from($englishDate)->toNepaliDate($format, $locale);

            $primaryRaw = $primaryCalendar === 'en' ? $englishDate : $nepaliDate;

            if ($this->option('json')) {
                $payload = [
                    'timezone' => $timezone ?? 'UTC',
                    'format' => $format,
                    'locale' => $locale,
                    'en' => [
                        'raw' => $englishDate,
                        'formatted' => $englishFormatted,
                    ],
                    'np' => [
                        'raw' => $nepaliDate,
                        'formatted' => $nepaliFormatted,
                    ],
                    'primary_calendar' => $primaryCalendar,
                ];

                $this->line(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                return self::SUCCESS;
            }

            if ($this->option('quiet')) {
                $this->line($primaryRaw);

                return self::SUCCESS;
            }

            if ($primaryCalendar === 'en') {
                $this->line("Today (en): {$englishDate}");
                $this->line("Today (np): {$nepaliDate}");
            } else {
                $this->line("Today (np): {$nepaliDate}");
                $this->line("Today (en): {$englishDate}");
            }

            $this->line("Formatted (en): {$englishFormatted}");
            $this->line("Formatted (np): {$nepaliFormatted}");

            return self::SUCCESS;
        } catch (InvalidArgumentException | RuntimeException $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }
    }
}
