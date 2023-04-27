<?php

declare(strict_types=1);

namespace j45l\Cats\Validated;

use j45l\Cats\Either\Failure;
use j45l\Cats\Either\Reason\Reason;

use function j45l\functional\butLast;
use function j45l\functional\last;
use function j45l\functional\map;
use function j45l\functional\pipe;
use function j45l\functional\with;

final readonly class Failed implements Reason
{
    /** @param Failure<mixed>[] $failures */
    private function __construct(public array $failures)
    {
    }

    /** @param Failure<mixed>[] $failures */
    public static function create(array $failures): Failed
    {
        return new self($failures);
    }

    public function __toString(): string
    {
        return with(
            map(butLast($this->failures), fn (Failure $failure) => (string) $failure->reason),
            (string) (last($this->failures)->reason ?? 'none')
        )(
            static fn (array $butLastFailures, string $lastFailure): string =>
                sprintf(
                    'Failed: %s',
                    pipe(
                        fn (): string => implode(',', $butLastFailures),
                        fn (string $butLastFailures): string =>
                            $butLastFailures === ''
                            ? $lastFailure
                            : sprintf('%s and %s', $butLastFailures, $lastFailure)
                    )
                )
        );
    }
}
