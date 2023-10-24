<?php

namespace Anuzpandey\LaravelNepaliDate;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Anuzpandey\LaravelNepaliDate\Commands\LaravelNepaliDateCommand;

class LaravelNepaliDateServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-nepali-date');
            // ->hasConfigFile()
            // ->hasViews()
            // ->hasMigration('create_laravel-nepali-date_table')
            // ->hasCommand(LaravelNepaliDateCommand::class);
    }
}
