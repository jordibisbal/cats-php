<?php

declare(strict_types=1);

namespace j45l\Cats\Either;

use Closure;
use j45l\functional\Sequences\FibonacciSequence;
use j45l\functional\Sequences\Sequence;

use function j45l\functional\pipe;
use function j45l\functional\with;

/**
 * @template T
 * @param Closure(int $tryCount, bool $lastTry):T $action
 * @param Sequence<float>|Sequence<int>|null $delaySequence
 * @param Closure(float $seconds):void|null $sleep
 * @return Either<T>
 */
function retry(Closure $action, int $maxTries, Sequence $delaySequence = null, Closure $sleep = null): Either
{
    $delaySequence ??= FibonacciSequence::create();
    $sleep ??= static fn (float $seconds) => usleep((int) $seconds * 1_000_000);

    return with($action, $maxTries, $delaySequence, $sleep, 1)(
        $recurse = static function (
            Closure $action,
            int $maxTries,
            Sequence $delaySequence,
            Closure $sleep,
            int $tryCount
        ) use (&$recurse) {
            return doTry(
                fn () => $action($tryCount, $tryCount === $maxTries)
            )->orElse(
                fn (Failure $failure) => match (true) {
                    $tryCount < $maxTries => pipe(
                        fn () => $sleep((float) $delaySequence->current()),
                        fn () => $recurse($action, $maxTries, $delaySequence->next(), $sleep, $tryCount + 1)
                    ),
                    default => $failure
                }
            );
        }
    );
}
