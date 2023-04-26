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
     */
    abstract public static function pure(mixed $value): static;

    /**
     * @param Applicative<A> $applicative
     */
    abstract public function apply(Applicative $applicative): static;

    /**
     * @phpstan-param Closure(A):A $fn
     */
    public function map(Closure $fn): static
    {
        return static::pure($this->get())->apply($this);
    }

    /**
     * @return A
     */
    abstract public function get(): mixed;
}
