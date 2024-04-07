<?php

namespace Anuzpandey\LaravelNepaliDate;

use Anuzpandey\LaravelNepaliDate\Directives\NepaliDateDirective;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelNepaliDateServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-nepali-date')
            ->hasConfigFile();
    }

    public function boot(): void
    {
        parent::boot();
        NepaliDateDirective::register();
    }
}
