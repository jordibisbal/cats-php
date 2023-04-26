<?php

declare(strict_types=1);

namespace j45l\Cats\Either\Reason;

use Error;

final readonly class BecauseError implements Reason
{
    private function __construct(public Error $error)
    {
    }

    public static function of(Error $error): self
    {
        return new self($error);
    }

    public function __toString(): string
    {
        return $this->error->getMessage();
    }

    public function toString(): string
    {
        return (string) $this;
    }
}
