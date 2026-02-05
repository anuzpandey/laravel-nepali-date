<?php

namespace Anuzpandey\LaravelNepaliDate;

use Anuzpandey\LaravelNepaliDate\Console\Commands\ConvertNepaliDateCommand;
use Anuzpandey\LaravelNepaliDate\Console\Commands\RangeNepaliDateCommand;
use Anuzpandey\LaravelNepaliDate\Console\Commands\TodayNepaliDateCommand;
use Anuzpandey\LaravelNepaliDate\Directives\NepaliDateDirective;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelNepaliDateServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-nepali-date')
            ->hasConfigFile()
            ->hasCommands([
                ConvertNepaliDateCommand::class,
                TodayNepaliDateCommand::class,
                RangeNepaliDateCommand::class,
            ]);
    }

    public function boot(): void
    {
        parent::boot();
        NepaliDateDirective::register();
    }
}
