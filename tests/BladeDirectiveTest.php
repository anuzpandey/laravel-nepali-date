<?php

use Anuzpandey\LaravelNepaliDate\Directives\NepaliDateDirective;
use Illuminate\Support\Facades\Blade;

beforeEach(function () {
    NepaliDateDirective::register();
});

it('registers nepaliDate blade directive', function () {
    $directives = Blade::getCustomDirectives();

    expect($directives)->toHaveKey('nepaliDate');
});

it('registers englishDate blade directive', function () {
    $directives = Blade::getCustomDirectives();

    expect($directives)->toHaveKey('englishDate');
});

it('compiles nepaliDate directive correctly', function () {
    $compiled = Blade::compileString("@nepaliDate('1996-04-22')");

    expect($compiled)->toContain('LaravelNepaliDate::from')
        ->toContain('toNepaliDate');
});

it('compiles englishDate directive correctly', function () {
    $compiled = Blade::compileString("@englishDate('2053-01-10')");

    expect($compiled)->toContain('LaravelNepaliDate::from')
        ->toContain('toEnglishDate');
});

it('compiles nepaliDate directive with format parameter', function () {
    $compiled = Blade::compileString("@nepaliDate('1996-04-22', 'Y-m-d')");

    expect($compiled)->toContain('LaravelNepaliDate::from')
        ->toContain('toNepaliDate');
});

it('compiles nepaliDate directive with format and locale parameters', function () {
    $compiled = Blade::compileString("@nepaliDate('1996-04-22', 'Y-m-d', 'np')");

    expect($compiled)->toContain('LaravelNepaliDate::from')
        ->toContain('toNepaliDate');
});

it('throws exception for too many arguments in directive', function () {
    NepaliDateDirective::register();

    // This will trigger the exception during directive parsing
    Blade::compileString("@nepaliDate('1996-04-22', 'Y-m-d', 'np', 'extra')");
})->throws(InvalidArgumentException::class, 'Too many arguments');
