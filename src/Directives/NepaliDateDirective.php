<?php

namespace Anuzpandey\LaravelNepaliDate\Directives;

use Illuminate\Support\Facades\Blade;

class NepaliDateDirective
{
    public static function register(): void
    {
        Blade::directive('nepaliDate', function ($date, $format, $locale) {
            return "<?php echo Anuzpandey\LaravelNepaliDate\LaravelNepaliDate::from($date)->toNepaliDate($format, $locale) ?>";
        });

        Blade::directive('englishDate', function ($date, $locale) {
            return "<?php echo Anuzpandey\LaravelNepaliDate\LaravelNepaliDate::from($date)->toEnglishDate($locale) ?>";
        });
    }
}
