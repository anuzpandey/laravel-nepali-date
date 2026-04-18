<?php

namespace Anuzpandey\LaravelNepaliDate\Exceptions;

use InvalidArgumentException;

class InvalidDateException extends InvalidArgumentException
{
    public function __construct(string $message, private array $context = [])
    {
        parent::__construct($message);
    }

    public static function forDate(string $message, array $context = []): self
    {
        return new self($message, $context);
    }

    public function context(): array
    {
        return $this->context;
    }
}
