<?php

namespace Anuzpandey\LaravelNepaliDate\Directives;

use Illuminate\Support\Facades\Blade;

class NepaliDateDirective
{
    public static function register(): void
    {
        Blade::directive('nepaliDate', function (string $expression) {
            [$date, $format, $locale] = self::getParsedArguments($expression);

            return "<?php echo Anuzpandey\LaravelNepaliDate\LaravelNepaliDate::from({$date})->toNepaliDate({$format}, {$locale}) ?>";
        });

        Blade::directive('englishDate', function (string $expression) {
            [$date, $format, $locale] = self::getParsedArguments($expression);

            return "<?php echo Anuzpandey\LaravelNepaliDate\LaravelNepaliDate::from({$date})->toEnglishDate({$format}, {$locale}) ?>";
        });
    }

    private static function getParsedArguments(string $expression): array
    {
        $segments = explode(',', str_replace(['(', ')', ' '], '', $expression));
        $date = $segments[0] ?? null;
        $format = $segments[1] ?? null;
        $locale = $segments[2] ?? null;

        return [
            $date === 'now' ? 'now()' : $date,
            $format === 'null' ? null : $format,
            $locale === 'null' ? null : $locale,
        ];
    }
}
