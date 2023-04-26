<?php

declare(strict_types=1);

namespace j45l\Cats\Validated;

use j45l\Cats\Either\Failure;
use j45l\Cats\Either\Reason\Reason;

use function j45l\functional\butLast;
use function j45l\functional\map;

final class NotValidated implements Reason
{
    /** @param Failure<mixed>[] $failures */
    private function __construct(readonly public array $failures)
    {
    }

    /** @param Failure<mixed>[] $failures */
    public static function create(array $failures): NotValidated
    {
        return new self($failures);
    }

    public function __toString(): string
    {
        return sprintf(
            'Failed: %s',
            implode(',', map(butLast($this->failures), fn (Failure $failure) => (string) $failure->reason))
        );
    }
}
