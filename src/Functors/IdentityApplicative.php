<?php

declare(strict_types=1);

namespace j45l\Cats\Functors;

/**
 * @template A
 * @extends Applicative<A>
 */
final class IdentityApplicative extends Applicative
{
    private function __construct(private readonly mixed $value)
    {
    }

    /**
     * @param A $value
     */
    public static function pure(mixed $value): static
    {
        return new static($value);
    }

    /**
     * @param Applicative<A> $applicative
     */
    public function apply(Applicative $applicative): static
    {
        return static::pure($this->get()($applicative->get()));
    }

    /**
     * @return A
     */
    public function get(): mixed
    {
        return $this->value;
    }
}
