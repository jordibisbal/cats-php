<?php

declare(strict_types=1);

namespace j45l\Cats\Either;

use Closure;
use Exception;
use j45l\Cats\Functors\Functor;
use j45l\Cats\Either\Reason\BecauseException;
use j45l\Cats\Maybe\Maybe;

/**
 * @template Right
 * @implements Functor<Right>
 */
abstract class Either implements Functor
{
    /**
     * @template Result
     * @param callable():Result $fn
     * @phpstan-return Either<Result>
     */
    public static function try(callable $fn): Either
    {
        try {
            return Success::pure($fn());
        } catch (Exception $exception) {
            return Failure::because(BecauseException::of($exception));
        }
    }

    /**
     * @template Result
     * @param callable(Right):Result $fn
     * @return $this|Either<Result>
     */
    abstract public function orElse(callable $fn): self;

    /**
     * @template Result
     * @param Result $value
     * @return Result|Right
     */
    abstract public function getOrElse(mixed $value): mixed;

    /**
     * @template Result
     * @param callable(Right):Result $fn
     * @return self<Result>
     */
    abstract public function andThen(callable $fn): mixed;

    /**
     * @return Right
     */
    abstract public function getOrFail(string $message = null): mixed;

    /**
     * @phpstan-return Maybe<Right>
     */
    abstract public function toMaybe(): Maybe;

    /**
     * @phpstan-return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function map(Closure $fn): Either
    {
        return $this;
    }
}
