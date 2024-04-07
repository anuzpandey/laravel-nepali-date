<?php

namespace Anuzpandey\LaravelNepaliDate\Directives;

use Illuminate\Support\Facades\Blade;
use InvalidArgumentException;

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

    private static function getParsedArguments(string $inputArguments): array
    {
        $expression = explode(',', str_replace(['(', ')'], '', $inputArguments));
        $date = isset($expression[0]) ? trim($expression[0]) : 'null';
        $format = isset($expression[1]) ? trim($expression[1]) : 'null';
        $locale = isset($expression[2]) ? trim($expression[2]) : 'null';

        if (count($expression) > 3) {
            throw new InvalidArgumentException(
                'Too many arguments provided for the directive OR You have placed comma in the date format. Comma in the date format is not supported yet.',
            );
        }

        return [
            $date === 'now' ? 'now()' : $date,
            $format,
            $locale,
        ];
    }
}
