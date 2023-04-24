<?php

declare(strict_types=1);

namespace j45l\Cats\Functors;

use Closure;

/**
 * @template A
 * @implements Functor<A>
 */
abstract class Applicative implements Functor
{
    /**
     * @phpstan-param A $value
     * @return Applicative<A>
     */
    abstract public static function pure(mixed $value): Applicative;

    /**
     * @param Applicative<A> $applicative
     * @return Applicative<A>
     */
    abstract public function apply(Applicative $applicative): Applicative;

    /**
     * @phpstan-param Closure(A):A $fn
     * @return Applicative<A>
     */
    public function map(Closure $fn): Applicative
    {
        return static::pure($fn)->apply($this);
    }

    /**
     * @return A
     */
    abstract public function get(): mixed;
}
