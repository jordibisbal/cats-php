<?php

declare(strict_types=1);

namespace j45l\Cats\Maybe;

use Closure;
use JetBrains\PhpStorm\Pure;

/**
 * @template T
 * @extends Maybe<T>
 */
final class Some extends Maybe
{
    /** @param T $value */
    private function __construct(private readonly mixed $value)
    {
    }

    /**
     * @param T $value
     * @phpstan-return self<T>
     */
    #[Pure]
    public static function pure(mixed $value): self
    {
        return new self($value);
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @return Maybe<R>
     */
    #[Pure]
    public function andThen(callable $fn): Maybe
    {
        /** @phpstan-ignore-next-line */
        return Maybe::of($fn($this->get()));
    }

    /**
     * @return T
     */
    #[Pure]
    public function get(): mixed
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return T
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    #[Pure]
    public function getOrElse(mixed $value): mixed
    {
        return $this->value;
    }

    /**
     * @return T
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    #[Pure]
    public function getOrFail(string $message = null): mixed
    {
        return $this->get();
    }

    /** @return T */
    #[Pure]
    public function getOrNull(): mixed
    {
        return $this->get();
    }

    /**
     * @template T2
     * @param Closure(T):T2 $fn
     * @phpstan-return static<T2>
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function map(Closure $fn): static
    {
        return new self($fn($this->value));
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @phpstan-return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    #[Pure]
    public function orElse(callable $fn): self
    {
        return $this;
    }
}
