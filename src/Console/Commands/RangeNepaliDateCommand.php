<?php

namespace Anuzpandey\LaravelNepaliDate\Console\Commands;

use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use DateInterval;
use DateTimeImmutable;
use InvalidArgumentException;
use RuntimeException;

class RangeNepaliDateCommand extends BaseNepaliDateCommand
{
    protected $signature = 'nepali-date:range
        {--from= : Start date (required)}
        {--until= : End date (required)}
        {--end= : Alias for --until}
        {--to= : Target calendar en|np}
        {--calendar=en : Input calendar en|np}
        {--format= : Output format}
        {--locale= : Output locale en|np}
        {--limit=366 : Max number of days to output}
        {--strict : Enable strict date validation}
        {--json : Emit machine-readable JSON output}
        {--timezone= : Timezone for datetime parsing}';

    protected $description = 'List a range of converted dates between calendars.';

    public function handle(): int
    {
        try {
            $from = $this->option('from');
            $until = $this->option('until') ?: $this->option('end');

            if (! $from) {
                throw new InvalidArgumentException('The --from option is required.');
            }

            if (! $until) {
                throw new InvalidArgumentException('The --until option is required.');
            }

            $inputCalendar = $this->normalizeCalendar($this->option('calendar'), 'calendar');
            $targetCalendar = $this->option('to')
                ? $this->normalizeCalendar($this->option('to'), 'to')
                : ($inputCalendar === 'en' ? 'np' : 'en');

            if ($inputCalendar === $targetCalendar) {
                throw new InvalidArgumentException('Input and output calendars must be different.');
            }

            $format = $this->resolveFormat($this->option('format'));
            $locale = $this->normalizeLocale($this->option('locale'));
            $limit = (int) ($this->option('limit') ?? 366);
            $strict = (bool) $this->option('strict');

            if ($limit < 1) {
                throw new InvalidArgumentException('The --limit option must be at least 1.');
            }

            if ($inputCalendar === 'en') {
                [$startYear, $startMonth, $startDay, $startRaw] = $this->parseInputDate($from, 'Y-m-d', $inputCalendar, $strict);
                [$endYear, $endMonth, $endDay, $endRaw] = $this->parseInputDate($until, 'Y-m-d', $inputCalendar, $strict);

                $startDate = new DateTimeImmutable($this->normalizeDate($startYear, $startMonth, $startDay));
                $endDate = new DateTimeImmutable($this->normalizeDate($endYear, $endMonth, $endDay));
            } else {
                [$startYear, $startMonth, $startDay, $startRaw] = $this->parseInputDate($from, 'Y-m-d', $inputCalendar, $strict);
                [$endYear, $endMonth, $endDay, $endRaw] = $this->parseInputDate($until, 'Y-m-d', $inputCalendar, $strict);

                $startEnglish = LaravelNepaliDate::from($this->normalizeDate($startYear, $startMonth, $startDay))
                    ->toEnglishDate('Y-m-d', 'en');
                $endEnglish = LaravelNepaliDate::from($this->normalizeDate($endYear, $endMonth, $endDay))
                    ->toEnglishDate('Y-m-d', 'en');

                $startDate = new DateTimeImmutable($startEnglish);
                $endDate = new DateTimeImmutable($endEnglish);
            }

            $diff = $startDate->diff($endDate);
            $days = (int) $diff->format('%r%a');

            if ($days < 0) {
                throw new InvalidArgumentException('The --from date must be on or before the --until date.');
            }

            $totalDays = $days + 1;

            if ($totalDays > $limit) {
                throw new InvalidArgumentException("Range spans {$totalDays} days which exceeds the limit of {$limit}. Use --limit to increase.");
            }

            $items = [];
            $current = $startDate;

            for ($i = 0; $i < $totalDays; $i++) {
                $englishDate = $current->format('Y-m-d');

                if ($inputCalendar === 'en') {
                    $inputDate = $englishDate;
                } else {
                    $inputDate = LaravelNepaliDate::from($englishDate)->toNepaliDate('Y-m-d', 'en');
                }

                if ($targetCalendar === 'np') {
                    $outputDate = LaravelNepaliDate::from($englishDate)->toNepaliDate('Y-m-d', 'en');
                    $formatted = LaravelNepaliDate::from($englishDate)->toNepaliDate($format, $locale);
                } else {
                    $outputDate = $englishDate;
                    $formatted = $this->formatEnglishDate($englishDate, $format, $locale);
                }

                $items[] = [
                    'input' => $inputDate,
                    'output' => $outputDate,
                    'formatted' => $formatted,
                ];

                $current = $current->add(new DateInterval('P1D'));
            }

            if ($this->option('json')) {
                $payload = [
                    'range' => [
                        'from' => $from,
                        'until' => $until,
                        'calendar' => $inputCalendar,
                        'output_calendar' => $targetCalendar,
                    ],
                    'format' => $format,
                    'locale' => $locale,
                    'items' => $items,
                ];

                $this->line(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                return self::SUCCESS;
            }

            foreach ($items as $item) {
                if ($this->option('quiet')) {
                    $this->line("{$item['input']} -> {$item['output']}");
                } else {
                    $this->line("{$item['input']} -> {$item['output']} | formatted: {$item['formatted']}");
                }
            }

            return self::SUCCESS;
        } catch (InvalidArgumentException | RuntimeException $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }
    }
}
