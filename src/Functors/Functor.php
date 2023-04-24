<?php

declare(strict_types=1);

namespace j45l\Cats\Functors;

use Closure;

/** @template A */
interface Functor
{
    /**
     * @template B
     * @param Closure(A):B $fn
     * @return Functor<B>
     */
    public function map(Closure $fn): Functor;
}
