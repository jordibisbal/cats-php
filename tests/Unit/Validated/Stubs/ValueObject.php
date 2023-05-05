<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Validated\Stubs;

final readonly class ValueObject
{
    private function __construct(readonly mixed $a, readonly mixed $b)
    {
    }

    public static function create(int $a, int $b): ValueObject
    {
        return new self($a, $b);
    }
}
