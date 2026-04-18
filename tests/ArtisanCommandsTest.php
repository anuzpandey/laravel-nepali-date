<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

it('converts dates via artisan command', function () {
    $this->artisan('nepali-date:convert', [
        '--from' => '1996-04-22',
        '--to' => 'np',
        '--format' => 'l, d F Y',
        '--locale' => 'np',
    ])
        ->expectsOutput('Input: 1996-04-22 (en)')
        ->expectsOutput('Output: 2053-01-10 (np)')
        ->expectsOutput('Formatted: सोमबार, १० वैशाख २०५३')
        ->assertExitCode(0);
});

it('outputs json for convert command', function () {
    Artisan::call('nepali-date:convert', [
        '--from' => '1996-04-22',
        '--to' => 'np',
        '--format' => 'l, d F Y',
        '--locale' => 'np',
        '--json' => true,
    ]);

    $payload = json_decode(Artisan::output(), true);

    expect($payload)->toMatchArray([
        'input' => '1996-04-22',
        'input_calendar' => 'en',
        'output' => '2053-01-10',
        'output_calendar' => 'np',
        'formatted' => 'सोमबार, १० वैशाख २०५३',
        'format' => 'l, d F Y',
        'locale' => 'np',
    ]);
});

it('shows today in both calendars', function () {
    Carbon::setTestNow(Carbon::create(1996, 4, 22, 0, 0, 0, 'UTC'));
    config()->set('app.timezone', 'UTC');

    $this->artisan('nepali-date:today', [
        '--format' => 'Y-m-d',
        '--locale' => 'np',
    ])
        ->expectsOutput('Today (en): 1996-04-22')
        ->expectsOutput('Today (np): 2053-01-10')
        ->expectsOutput('Formatted (en): १९९६-०४-२२')
        ->expectsOutput('Formatted (np): २०५३-०१-१०')
        ->assertExitCode(0);

    Carbon::setTestNow();
});

it('lists a range of converted dates', function () {
    $this->artisan('nepali-date:range', [
        '--from' => '2080-01-01',
        '--until' => '2080-01-03',
        '--calendar' => 'np',
        '--to' => 'en',
        '--format' => 'Y-m-d',
        '--locale' => 'en',
    ])
        ->expectsOutput('2080-01-01 -> 2023-04-14 | formatted: 2023-04-14')
        ->expectsOutput('2080-01-02 -> 2023-04-15 | formatted: 2023-04-15')
        ->expectsOutput('2080-01-03 -> 2023-04-16 | formatted: 2023-04-16')
        ->assertExitCode(0);
});
