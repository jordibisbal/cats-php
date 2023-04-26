<?php

declare(strict_types=1);

namespace j45l\Cats\Either\Reason;

final readonly class BecauseNone implements Reason
{
    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function __toString(): string
    {
        return 'Because None';
    }

    public function toString(): string
    {
        return (string) $this;
    }
}
