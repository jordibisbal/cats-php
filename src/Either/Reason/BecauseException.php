<?php

declare(strict_types=1);

namespace j45l\Cats\Either\Reason;

use Exception;

final readonly class BecauseException implements Reason
{
    private function __construct(public Exception $exception)
    {
    }

    public static function of(Exception $exception): self
    {
        return new self($exception);
    }

    public function reason(): string
    {
        return $this->exception->getMessage();
    }
}
