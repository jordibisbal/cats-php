<?php

declare(strict_types=1);

namespace j45l\Cats\Maybe;

/**
 * @template T
 * @phpstan-param (T|null) $value
 * @phpstan-return ($value is null ? None<T> : Some<T>)
 */
function Maybe($value): Maybe
{
    return Maybe::ofNullable($value);
}

/**
 * @return None<mixed>
 */
function None(): None
{
    return None::create();
}

/**
 * @template T
 * @param T $value
 * @return Some<T>
 */
function Some(mixed $value): Some
{
    return Some::of($value);
}
