<?php

declare(strict_types=1);

namespace j45l\Cats\Either;

/** @return ($either is Success<mixed> ? true : false) */
function isSuccess(mixed $either): bool
{
    return $either instanceof Success;
}

function isEither(mixed $either): bool
{
    return $either instanceof Either;
}

function isFailure(mixed $either): bool
{
    return $either instanceof Failure;
}
