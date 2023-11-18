<?php

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

it('ensures traits are suffixed with Trait')
    ->expect('Anuzpandey\LaravelNepaliDate\Traits')
    ->toHaveSuffix('Trait');

it('ensures mixins are suffixed with Mixin')
    ->expect('Anuzpandey\LaravelNepaliDate\Mixin')
    ->toHaveSuffix('Mixin');
