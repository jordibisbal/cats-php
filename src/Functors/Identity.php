<?php

declare(strict_types=1);

namespace j45l\Cats\Functors;

use Closure;

/**
 * @template T
 * @implements Functor<T>
 */
final readonly class Identity implements Functor
{
    /** @var T */
    private mixed $value;

    /**
     * @param T $value
     */
    private function __construct(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * @param T $value
     * @return Identity<T>
     */
    public static function pure(mixed $value): Identity
    {
        return new self($value);
    }

    /**
     * @param Closure(T):T $fn
     * @return Functor<T>
     */
    public function map(Closure $fn): Functor
    {
        return self::pure($fn($this->value));
    }

    /**
     * @return T
     */
    public function get(): mixed
    {
        return $this->value;
    }
}
