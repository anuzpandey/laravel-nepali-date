<?php

namespace Anuzpandey\LaravelNepaliDate\Directives;

use Illuminate\Support\Facades\Blade;

class NepaliDateDirective
{
    public static function register(): void
    {
        Blade::directive('nepaliDate', function ($date = null, $format = null, $locale = null) {
            $date ??= now();
            return "<?php echo Anuzpandey\LaravelNepaliDate\LaravelNepaliDate::from($date)->toNepaliDate($format, $locale) ?>";
        });

        Blade::directive('englishDate', function ($date = null, $format = null, $locale = null) {
            $date ??= now();
            return "<?php echo Anuzpandey\LaravelNepaliDate\LaravelNepaliDate::from($date)->toEnglishDate($format, $locale) ?>";
        });
    }
}
