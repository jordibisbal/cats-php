<?php

declare(strict_types=1);

namespace j45l\Cats\Either\Reason;

final readonly class BecauseNull implements Reason
{
    /** @noinspection PhpSameParameterValueInspection */
    private function __construct(public string $reason)
    {
    }

    public static function create(): self
    {
        return new self('From None optional');
    }

    public function reason(): string
    {
        return $this->reason;
    }
}
