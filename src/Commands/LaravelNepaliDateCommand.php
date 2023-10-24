<?php

namespace Anuzpandey\LaravelNepaliDate\Commands;

use Illuminate\Console\Command;

class LaravelNepaliDateCommand extends Command
{
    public $signature = 'laravel-nepali-date';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
